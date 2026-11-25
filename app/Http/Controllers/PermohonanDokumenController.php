<?php

namespace App\Http\Controllers;

use App\Models\PermohonanDokumen;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PermohonanDokumenController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $isStaff = in_array($user->role, ['admin', 'koordinator']);

        $myDokumens = PermohonanDokumen::where('user_id', $user->id)
            ->latest()
            ->paginate(10, ['*'], 'my_page');

        $staffDokumens = null;
        if ($isStaff) {
            $staffDokumens = PermohonanDokumen::with('user.alumniProfile')
                ->orderByRaw("FIELD(status, 'diajukan', 'diverifikasi', 'diproses', 'siap_diambil', 'selesai', 'ditolak')")
                ->latest()
                ->paginate(15, ['*'], 'staff_page');
        }

        return view('permohonan-dokumen.index', compact('user', 'myDokumens', 'staffDokumens', 'isStaff'));
    }

    public function create(): View
    {
        return view('permohonan-dokumen.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_dokumen' => ['required', 'string'],
            'keperluan' => ['required', 'string'],
            'jumlah_eksemplar' => ['required', 'integer', 'min:1', 'max:20'],
            'metode_pengambilan' => ['required', 'string'],
            'alamat_pengiriman' => ['nullable', 'string'],
            'file_lampiran' => ['nullable', 'string'],
        ], [
            'jenis_dokumen.required' => 'Pilih jenis permohonan dokumen.',
            'keperluan.required' => 'Keperluan permohonan wajib diisi.',
            'jumlah_eksemplar.required' => 'Jumlah eksemplar wajib diisi.',
            'metode_pengambilan.required' => 'Metode pengambilan wajib dipilih.',
        ]);

        $nomor = 'DOK-'.date('Ym').'-'.strtoupper(Str::random(5));

        $dokumen = PermohonanDokumen::create([
            'user_id' => Auth::id(),
            'nomor_permohonan' => $nomor,
            'jenis_dokumen' => $validated['jenis_dokumen'],
            'keperluan' => $validated['keperluan'],
            'jumlah_eksemplar' => $validated['jumlah_eksemplar'],
            'metode_pengambilan' => $validated['metode_pengambilan'],
            'alamat_pengiriman' => $validated['alamat_pengiriman'] ?? null,
            'file_lampiran' => $validated['file_lampiran'] ?? null,
            'status' => 'diajukan',
        ]);

        return redirect()->route('permohonan-dokumen.show', $dokumen->id)
            ->with('success', 'Permohonan dokumen berhasil diajukan dengan nomor '.$nomor);
    }

    public function show(int $id): View
    {
        $dokumen = PermohonanDokumen::with('user.alumniProfile')->findOrFail($id);

        if ($dokumen->user_id !== Auth::id() && ! in_array(Auth::user()->role, ['admin', 'koordinator'])) {
            abort(403, 'Akses terbatas untuk permohonan ini.');
        }

        return view('permohonan-dokumen.show', compact('dokumen'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $dokumen = PermohonanDokumen::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:diajukan,diverifikasi,diproses,siap_diambil,selesai,ditolak'],
            'catatan_admin' => ['nullable', 'string'],
            'file_hasil' => ['nullable', 'string'],
        ]);

        $dokumen->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? $dokumen->catatan_admin,
            'file_hasil' => $validated['file_hasil'] ?? $dokumen->file_hasil,
        ]);

        return back()->with('success', "Status permohonan {$dokumen->nomor_permohonan} berhasil diperbarui.");
    }
}
