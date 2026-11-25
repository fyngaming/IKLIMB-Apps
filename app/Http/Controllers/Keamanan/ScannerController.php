<?php

namespace App\Http\Controllers\Keamanan;

use App\Http\Controllers\Controller;
use App\Models\AlumniProfile;
use App\Models\Kunjungan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ScannerController extends Controller
{
    public function index(): View
    {
        $todayKunjungans = Kunjungan::with('user.alumniProfile')
            ->whereDate('tanggal_kunjungan', date('Y-m-d'))
            ->orderBy('jam_kunjungan', 'asc')
            ->get();

        $recentCheckIns = Kunjungan::with('user.alumniProfile')
            ->whereNotNull('checked_in_at')
            ->latest('checked_in_at')
            ->limit(5)
            ->get();

        return view('keamanan.scanner', compact('todayKunjungans', 'recentCheckIns'));
    }

    public function verifyCode(Request $request): JsonResponse
    {
        $code = trim($request->input('code'));

        if (empty($code)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode QR kosong.',
            ], 422);
        }

        // 1. Check if it's a Visit Token or Visit Code (e.g. VISIT-... or KNJ-...)
        $kunjungan = Kunjungan::with('user.alumniProfile')
            ->where('qr_visit_token', $code)
            ->orWhere('kode_kunjungan', $code)
            ->first();

        if ($kunjungan) {
            return response()->json([
                'success' => true,
                'type' => 'kunjungan',
                'data' => [
                    'id' => $kunjungan->id,
                    'kode_kunjungan' => $kunjungan->kode_kunjungan,
                    'nama_alumni' => $kunjungan->user->name,
                    'no_wa' => $kunjungan->user->no_wa,
                    'nis' => $kunjungan->user->alumniProfile->nis ?? '-',
                    'angkatan' => $kunjungan->user->alumniProfile->angkatan ?? '-',
                    'tanggal_kunjungan' => $kunjungan->tanggal_kunjungan->format('d M Y'),
                    'jam_kunjungan' => substr($kunjungan->jam_kunjungan, 0, 5).' WIB',
                    'tujuan' => $kunjungan->tujuan,
                    'pihak_ditemui' => $kunjungan->pihak_ditemui,
                    'jumlah_rombongan' => $kunjungan->jumlah_rombongan,
                    'kendaraan' => $kunjungan->kendaraan ?? 'Kendaraan Pribadi',
                    'status' => $kunjungan->status,
                    'checked_in_at' => $kunjungan->checked_in_at ? $kunjungan->checked_in_at->format('d M Y H:i') : null,
                ],
            ]);
        }

        // 2. Check if it's an Alumni Identity Token (e.g. IKLIMB-...)
        $profile = AlumniProfile::with('user.educations')
            ->where('qr_identity_token', $code)
            ->first();

        if ($profile) {
            return response()->json([
                'success' => true,
                'type' => 'identitas',
                'data' => [
                    'nama_alumni' => $profile->user->name,
                    'no_wa' => $profile->user->no_wa,
                    'nis' => $profile->nis,
                    'angkatan' => $profile->angkatan,
                    'jenjang_pondok' => $profile->jenjang_pondok,
                    'domisili' => ($profile->kabupaten_kota ?? '-').', '.($profile->provinsi ?? '-'),
                    'pekerjaan' => $profile->pekerjaan_lembaga ?? 'Tidak dicantumkan',
                    'status_verifikasi' => $profile->user->status === 'aktif' ? 'Terverifikasi Resmi' : 'Belum Diverifikasi',
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Kode QR tidak dikenali di sistem IKLIMB. Pastikan QR valid.',
        ], 404);
    }

    public function checkIn(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $kunjungan = Kunjungan::findOrFail($id);

        $kunjungan->update([
            'checked_in_at' => now(),
            'checked_in_by' => Auth::id(),
            'status' => 'selesai',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Check-in kunjungan {$kunjungan->kode_kunjungan} berhasil dicatat oleh Petugas Keamanan.",
                'checked_in_at' => $kunjungan->checked_in_at->format('d M Y H:i:s'),
            ]);
        }

        return back()->with('success', "Check-in kunjungan {$kunjungan->kode_kunjungan} berhasil dicatat!");
    }
}
