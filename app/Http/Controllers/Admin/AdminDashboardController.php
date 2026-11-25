<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonasiProgram;
use App\Models\DonasiTransaksi;
use App\Models\KabarPondok;
use App\Models\KajianMateri;
use App\Models\Kunjungan;
use App\Models\PermohonanDokumen;
use App\Models\TanyaUstaz;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Overview Admin Dashboard
     */
    public function index(): View
    {
        $stats = [
            'total_alumni' => User::where('role', 'alumni')->count(),
            'alumni_aktif' => User::where('role', 'alumni')->where('status', 'aktif')->count(),
            'alumni_pending' => User::where('role', 'alumni')->where('status', 'menunggu_verifikasi')->count(),
            'donasi_programs' => DonasiProgram::count(),
            'donasi_aktif' => DonasiProgram::where('is_aktif', true)->count(),
            'dana_terkumpul' => DonasiProgram::sum('dana_terkumpul'),
            'dokumen_pending' => PermohonanDokumen::whereIn('status', ['diajukan', 'diverifikasi', 'diproses'])->count(),
            'kunjungan_pending' => Kunjungan::where('status', 'menunggu')->count(),
            'kajian_count' => KajianMateri::count(),
            'tanya_ustaz_pending' => TanyaUstaz::where('status', 'menunggu_jawaban')->count(),
            'kabar_count' => KabarPondok::count(),
        ];

        $recentDokumen = PermohonanDokumen::with('user')->latest()->take(5)->get();
        $recentKunjungan = Kunjungan::with('user')->latest()->take(5)->get();
        $recentTanyaUstaz = TanyaUstaz::with('penanya')->where('status', 'menunggu_jawaban')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentDokumen', 'recentKunjungan', 'recentTanyaUstaz'));
    }

    /**
     * 1. Manajemen Kabar Pondok
     */
    public function kabarIndex(): View
    {
        $articles = KabarPondok::with('author')->latest()->paginate(15);

        return view('admin.kabar', compact('articles'));
    }

    public function kabarStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'gambar_url' => ['nullable', 'string', 'max:1000'],
            'gambar' => ['nullable', 'string'],
            'is_pinned' => ['nullable', 'boolean'],
            'status' => ['required', 'in:published,draft'],
        ]);

        $gambar = null;
        if ($request->hasFile('gambar_file')) {
            $path = $request->file('gambar_file')->store('kabar', 'public');
            $gambar = '/storage/'.$path;
        } elseif ($request->filled('gambar_url')) {
            $gambar = $request->input('gambar_url');
        } elseif ($request->filled('gambar')) {
            $gambar = $request->input('gambar');
        } else {
            $gambar = 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?auto=format&fit=crop&w=800&q=80';
        }

        KabarPondok::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'slug' => Str::slug($validated['judul']).'-'.Str::lower(Str::random(5)),
            'kategori' => $validated['kategori'],
            'ringkasan' => $validated['ringkasan'],
            'konten' => $validated['konten'],
            'gambar' => $gambar,
            'is_pinned' => $request->boolean('is_pinned'),
            'published_at' => $validated['status'] === 'published' ? now() : null,
            'views_count' => 0,
        ]);

        return redirect()->route('admin.kabar.index')->with('success', 'Kabar pondok berhasil diterbitkan.');
    }

    public function kabarUpdate(Request $request, int $id): RedirectResponse
    {
        $article = KabarPondok::findOrFail($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'gambar_url' => ['nullable', 'string', 'max:1000'],
            'gambar' => ['nullable', 'string'],
            'is_pinned' => ['nullable', 'boolean'],
            'status' => ['required', 'in:published,draft'],
        ]);

        $gambar = $article->gambar;
        if ($request->hasFile('gambar_file')) {
            $path = $request->file('gambar_file')->store('kabar', 'public');
            $gambar = '/storage/'.$path;
        } elseif ($request->filled('gambar_url')) {
            $gambar = $request->input('gambar_url');
        } elseif ($request->filled('gambar')) {
            $gambar = $request->input('gambar');
        }

        $article->update([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'ringkasan' => $validated['ringkasan'],
            'konten' => $validated['konten'],
            'gambar' => $gambar,
            'is_pinned' => $request->boolean('is_pinned'),
            'published_at' => $validated['status'] === 'published' ? ($article->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.kabar.index')->with('success', 'Kabar pondok berhasil diperbarui.');
    }

    public function kabarDestroy(int $id): RedirectResponse
    {
        $article = KabarPondok::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.kabar.index')->with('success', 'Kabar pondok berhasil dihapus.');
    }

    /**
     * 2. Manajemen Donasi & Wakaf
     */
    public function donasiIndex(): View
    {
        $programs = DonasiProgram::withCount('transaksis')->latest()->paginate(12);
        $recentTransactions = DonasiTransaksi::with(['program', 'user'])->latest()->take(10)->get();

        return view('admin.donasi', compact('programs', 'recentTransactions'));
    }

    public function donasiStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'target_dana' => ['required', 'numeric', 'min:100000'],
            'tanggal_berakhir' => ['nullable', 'date'],
            'deskripsi' => ['required', 'string'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'gambar_url' => ['nullable', 'string', 'max:1000'],
            'gambar' => ['nullable', 'string'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        $gambar = null;
        if ($request->hasFile('gambar_file')) {
            $path = $request->file('gambar_file')->store('donasi', 'public');
            $gambar = '/storage/'.$path;
        } elseif ($request->filled('gambar_url')) {
            $gambar = $request->input('gambar_url');
        } elseif ($request->filled('gambar')) {
            $gambar = $request->input('gambar');
        } else {
            $gambar = 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&w=800&q=80';
        }

        DonasiProgram::create([
            'judul' => $validated['judul'],
            'slug' => Str::slug($validated['judul']).'-'.Str::lower(Str::random(4)),
            'kategori' => $validated['kategori'],
            'target_dana' => $validated['target_dana'],
            'dana_terkumpul' => 0,
            'tanggal_berakhir' => $validated['tanggal_berakhir'] ?? null,
            'deskripsi' => $validated['deskripsi'],
            'gambar' => $gambar,
            'is_aktif' => $request->has('is_aktif') ? $request->boolean('is_aktif') : true,
        ]);

        return redirect()->route('admin.donasi.index')->with('success', 'Program donasi / wakaf baru berhasil dibuka.');
    }

    public function donasiUpdate(Request $request, int $id): RedirectResponse
    {
        $program = DonasiProgram::findOrFail($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'target_dana' => ['required', 'numeric', 'min:100000'],
            'dana_terkumpul' => ['nullable', 'numeric', 'min:0'],
            'tanggal_berakhir' => ['nullable', 'date'],
            'deskripsi' => ['required', 'string'],
            'gambar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'gambar_url' => ['nullable', 'string', 'max:1000'],
            'gambar' => ['nullable', 'string'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        $gambar = $program->gambar;
        if ($request->hasFile('gambar_file')) {
            $path = $request->file('gambar_file')->store('donasi', 'public');
            $gambar = '/storage/'.$path;
        } elseif ($request->filled('gambar_url')) {
            $gambar = $request->input('gambar_url');
        } elseif ($request->filled('gambar')) {
            $gambar = $request->input('gambar');
        }

        $program->update([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'target_dana' => $validated['target_dana'],
            'dana_terkumpul' => $validated['dana_terkumpul'] ?? $program->dana_terkumpul,
            'tanggal_berakhir' => $validated['tanggal_berakhir'] ?? null,
            'deskripsi' => $validated['deskripsi'],
            'gambar' => $gambar,
            'is_aktif' => $request->boolean('is_aktif'),
        ]);

        return redirect()->route('admin.donasi.index')->with('success', 'Data program donasi berhasil diperbarui.');
    }

    public function donasiDestroy(int $id): RedirectResponse
    {
        $program = DonasiProgram::findOrFail($id);
        $program->delete();

        return redirect()->route('admin.donasi.index')->with('success', 'Program donasi berhasil dihapus.');
    }

    /**
     * 3. Manajemen Dokumen Tata Usaha (TU)
     */
    public function dokumenIndex(Request $request): View
    {
        $status = $request->query('status');
        $query = PermohonanDokumen::with('user');

        if ($status) {
            $query->where('status', $status);
        }

        $documents = $query->latest()->paginate(15);

        return view('admin.dokumen', compact('documents', 'status'));
    }

    public function dokumenUpdateStatus(Request $request, int $id): RedirectResponse
    {
        $document = PermohonanDokumen::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:diajukan,diverifikasi,diproses,siap_diambil,selesai,ditolak'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $document->update($validated);

        return redirect()->route('admin.dokumen.index')->with('success', "Status permohonan #{$document->nomor_permohonan} berhasil diubah menjadi {$document->status}.");
    }

    /**
     * 4. Manajemen Kajian & Materi
     */
    public function kajianIndex(): View
    {
        $kajianList = KajianMateri::latest('published_at')->paginate(15);

        return view('admin.kajian', compact('kajianList'));
    }

    public function kajianStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'nama_narasumber' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'media_type' => ['required', 'in:youtube,audio,artikel'],
            'media_url' => ['nullable', 'string'],
            'ringkasan' => ['required', 'string'],
            'konten' => ['nullable', 'string'],
        ]);

        KajianMateri::create([
            'judul' => $validated['judul'],
            'slug' => Str::slug($validated['judul']).'-'.Str::lower(Str::random(4)),
            'nama_narasumber' => $validated['nama_narasumber'],
            'kategori' => $validated['kategori'],
            'media_type' => $validated['media_type'],
            'media_url' => $validated['media_url'] ?? null,
            'ringkasan' => $validated['ringkasan'],
            'konten' => $validated['konten'] ?? $validated['ringkasan'],
            'published_at' => now(),
        ]);

        return redirect()->route('admin.kajian.index')->with('success', 'Materi kajian baru berhasil ditambahkan.');
    }

    public function kajianUpdate(Request $request, int $id): RedirectResponse
    {
        $kajian = KajianMateri::findOrFail($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'nama_narasumber' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'media_type' => ['required', 'in:youtube,audio,artikel'],
            'media_url' => ['nullable', 'string'],
            'ringkasan' => ['required', 'string'],
            'konten' => ['nullable', 'string'],
        ]);

        $kajian->update($validated);

        return redirect()->route('admin.kajian.index')->with('success', 'Materi kajian berhasil diperbarui.');
    }

    public function kajianDestroy(int $id): RedirectResponse
    {
        $kajian = KajianMateri::findOrFail($id);
        $kajian->delete();

        return redirect()->route('admin.kajian.index')->with('success', 'Materi kajian berhasil dihapus.');
    }

    /**
     * 5. Manajemen Tanya Ustaz
     */
    public function tanyaUstazIndex(): View
    {
        $questions = TanyaUstaz::with('penanya')->latest()->paginate(15);

        return view('admin.tanya-ustaz', compact('questions'));
    }

    public function tanyaUstazAnswer(Request $request, int $id): RedirectResponse
    {
        $question = TanyaUstaz::findOrFail($id);

        $validated = $request->validate([
            'nama_ustaz_penjawab' => ['required', 'string', 'max:255'],
            'jawaban' => ['required', 'string'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $question->update([
            'dijawab_oleh' => Auth::id(),
            'nama_ustaz_penjawab' => $validated['nama_ustaz_penjawab'],
            'jawaban' => $validated['jawaban'],
            'is_public' => $request->boolean('is_public'),
            'status' => 'dijawab',
            'answered_at' => now(),
        ]);

        return redirect()->route('admin.tanya-ustaz.index')->with('success', 'Jawaban konsultasi ustaz berhasil disimpan & dikirim ke penanya.');
    }
}
