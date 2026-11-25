<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KunjunganController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        // If Koordinator or Admin, show management tab
        $isStaff = $user->role === 'koordinator' || $user->role === 'admin' || $user->role === 'keamanan';

        $myKunjungans = Kunjungan::where('user_id', $user->id)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_kunjungan', 'desc')
            ->paginate(10, ['*'], 'my_page');

        $staffKunjungans = null;
        if ($isStaff) {
            $staffKunjungans = Kunjungan::with('user.alumniProfile')
                ->orderByRaw("FIELD(status, 'menunggu', 'dijadwalkan_ulang', 'disetujui', 'selesai', 'ditolak')")
                ->orderBy('tanggal_kunjungan', 'asc')
                ->paginate(15, ['*'], 'staff_page');
        }

        return view('kunjungan.index', compact('user', 'myKunjungans', 'staffKunjungans', 'isStaff'));
    }

    public function create(): View
    {
        return view('kunjungan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'jam_kunjungan' => ['required'],
            'tujuan' => ['required', 'string'],
            'pihak_ditemui' => ['required', 'string', 'max:150'],
            'jumlah_rombongan' => ['required', 'integer', 'min:1', 'max:50'],
            'kendaraan' => ['nullable', 'string', 'max:100'],
            'is_menginap' => ['nullable', 'boolean'],
            'catatan_alumni' => ['nullable', 'string'],
        ], [
            'tanggal_kunjungan.required' => 'Tanggal kunjungan wajib diisi.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lampau.',
            'jam_kunjungan.required' => 'Jam estimasi tiba wajib diisi.',
            'pihak_ditemui.required' => 'Pihak yang ingin ditemui wajib diisi.',
            'jumlah_rombongan.required' => 'Jumlah rombongan wajib diisi.',
        ]);

        $kode = 'KNJ-'.date('Ymd').'-'.strtoupper(Str::random(5));
        $qrToken = 'VISIT-'.strtoupper(Str::random(16));

        $kunjungan = Kunjungan::create([
            'user_id' => Auth::id(),
            'kode_kunjungan' => $kode,
            'qr_visit_token' => $qrToken,
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'jam_kunjungan' => $validated['jam_kunjungan'],
            'tujuan' => $validated['tujuan'],
            'pihak_ditemui' => $validated['pihak_ditemui'],
            'jumlah_rombongan' => $validated['jumlah_rombongan'],
            'kendaraan' => $validated['kendaraan'] ?? 'Kendaraan Pribadi',
            'is_menginap' => $request->boolean('is_menginap'),
            'catatan_alumni' => $validated['catatan_alumni'] ?? null,
            'status' => 'menunggu',
        ]);

        return redirect()->route('kunjungan.show', $kunjungan->id)
            ->with('success', 'Rencana kunjungan berhasil diajukan! Menunggu konfirmasi pengurus.');
    }

    public function show(int $id): View
    {
        $kunjungan = Kunjungan::with(['user.alumniProfile', 'securityUser'])->findOrFail($id);

        // Security check
        if ($kunjungan->user_id !== Auth::id() && ! in_array(Auth::user()->role, ['admin', 'koordinator', 'keamanan'])) {
            abort(403, 'Akses terbatas untuk tiket kunjungan ini.');
        }

        $qrSvg = QrCode::size(220)
            ->color(6, 78, 59)
            ->backgroundColor(255, 255, 255)
            ->margin(1)
            ->generate($kunjungan->qr_visit_token);

        return view('kunjungan.show', compact('kunjungan', 'qrSvg'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:disetujui,dijadwalkan_ulang,selesai,ditolak'],
            'catatan_petugas' => ['nullable', 'string'],
            'jadwal_ulang_tanggal' => ['nullable', 'date'],
            'jadwal_ulang_jam' => ['nullable'],
        ]);

        $kunjungan->update([
            'status' => $validated['status'],
            'catatan_petugas' => $validated['catatan_petugas'] ?? $kunjungan->catatan_petugas,
            'jadwal_ulang_tanggal' => $validated['jadwal_ulang_tanggal'] ?? null,
            'jadwal_ulang_jam' => $validated['jadwal_ulang_jam'] ?? null,
        ]);

        return back()->with('success', "Status kunjungan {$kunjungan->kode_kunjungan} berhasil diperbarui menjadi {$validated['status']}.");
    }
}
