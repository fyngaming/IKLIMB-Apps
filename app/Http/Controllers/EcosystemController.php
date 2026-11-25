<?php

namespace App\Http\Controllers;

use App\Models\AgendaReuni;
use App\Models\AgendaRsvp;
use App\Models\AlumniProfile;
use App\Models\ForumAngkatan;
use App\Models\InfoLowonganUsaha;
use App\Models\KajianMateri;
use App\Models\PsbAlumni;
use App\Models\SaranMasukan;
use App\Models\TanyaUstaz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EcosystemController extends Controller
{
    // 7. PSB Jalur Alumni
    public function psbIndex(): View
    {
        $myPsb = PsbAlumni::where('user_id', Auth::id())->latest()->get();

        return view('ekosistem.psb', compact('myPsb'));
    }

    public function psbStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_calon_santri' => ['required', 'string'],
            'hubungan_keluarga' => ['required', 'string'],
            'tempat_lahir' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'jenjang_pilihan' => ['required', 'string'],
        ]);

        $noReg = 'PSB-ALUMNI-'.date('Y').'-'.strtoupper(Str::random(4));

        PsbAlumni::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'nomor_registrasi' => $noReg,
            'status_seleksi' => 'pendaftaran',
        ]));

        return back()->with('success', "Pendaftaran calon santri jalur alumni berhasil dengan No. Registrasi {$noReg}.");
    }

    // 8. Agenda & Reuni
    public function agendaIndex(): View
    {
        $agendas = AgendaReuni::with('rsvps')->orderBy('tanggal_mulai', 'asc')->get();

        return view('ekosistem.agenda', compact('agendas'));
    }

    public function agendaRsvp(Request $request, int $id): RedirectResponse
    {
        $agenda = AgendaReuni::findOrFail($id);

        $validated = $request->validate([
            'status_kehadiran' => ['required', 'in:Hadir,Tidak Hadir,Ragu-ragu'],
            'jumlah_tamu' => ['required', 'integer', 'min:1', 'max:10'],
            'catatan' => ['nullable', 'string'],
        ]);

        AgendaRsvp::updateOrCreate(
            ['agenda_reuni_id' => $agenda->id, 'user_id' => Auth::id()],
            $validated
        );

        return back()->with('success', 'Konfirmasi kehadiran (RSVP) berhasil disimpan.');
    }

    // 9. Info Lowongan & Usaha Alumni
    public function lowonganIndex(Request $request): View
    {
        $tipe = $request->query('tipe');
        $query = InfoLowonganUsaha::with('user')->where('is_verified', true);
        if ($tipe) {
            $query->where('tipe', $tipe);
        }
        $items = $query->latest()->paginate(10);

        return view('ekosistem.lowongan', compact('items', 'tipe'));
    }

    public function lowonganStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tipe' => ['required', 'in:lowongan_kerja,kebutuhan_dai,usaha_alumni'],
            'judul' => ['required', 'string'],
            'nama_perusahaan_usaha' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'lokasi' => ['required', 'string'],
            'kontak_wa' => ['required', 'string'],
            'link_website' => ['nullable', 'string'],
        ]);

        InfoLowonganUsaha::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'is_verified' => true,
        ]));

        return back()->with('success', 'Informasi lowongan / usaha Anda berhasil dipublikasikan.');
    }

    // 10. Peta Sebaran Alumni
    public function petaIndex(): View
    {
        $alumniLocations = AlumniProfile::with('user')
            ->whereNotNull('kabupaten_kota')
            ->whereHas('user', fn ($q) => $q->where('status', 'aktif'))
            ->get()
            ->groupBy('kabupaten_kota');

        return view('ekosistem.peta', compact('alumniLocations'));
    }

    // 11. Forum Angkatan
    public function forumIndex(): View
    {
        $forums = ForumAngkatan::orderBy('tahun_lulus', 'desc')->get();

        return view('ekosistem.forum', compact('forums'));
    }

    // 13. Kajian & Materi
    public function kajianIndex(): View
    {
        $kajianList = KajianMateri::latest('published_at')->get();

        return view('ekosistem.kajian', compact('kajianList'));
    }

    // 14. Tanya Ustaz
    public function tanyaUstazIndex(): View
    {
        $myQuestions = TanyaUstaz::where('user_id', Auth::id())->latest()->get();
        $publicAnswers = TanyaUstaz::where('is_public', true)
            ->where('status', 'dijawab')
            ->latest('answered_at')
            ->get();

        return view('ekosistem.tanya-ustaz', compact('myQuestions', 'publicAnswers'));
    }

    public function tanyaUstazStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_keilmuan' => ['required', 'string'],
            'judul_pertanyaan' => ['required', 'string'],
            'pertanyaan' => ['required', 'string'],
            'is_anonim' => ['nullable', 'boolean'],
        ]);

        TanyaUstaz::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'is_anonim' => $request->boolean('is_anonim'),
            'status' => 'menunggu_jawaban',
        ]));

        return back()->with('success', 'Pertanyaan Anda berhasil dikirim ke Asatizah PPIB.');
    }

    // 15. Saran & Masukan
    public function saranIndex(): View
    {
        $myAspirasi = SaranMasukan::where('user_id', Auth::id())->latest()->get();

        return view('ekosistem.saran', compact('myAspirasi'));
    }

    public function saranStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'topik' => ['required', 'string'],
            'isi_aspirasi' => ['required', 'string'],
        ]);

        SaranMasukan::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'terkirim',
        ]));

        return back()->with('success', 'Aspirasi & saran Anda berhasil disampaikan kepada Pengurus PPIB.');
    }
}
