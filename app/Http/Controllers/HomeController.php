<?php

namespace App\Http\Controllers;

use App\Models\KabarPondok;
use App\Models\Kunjungan;
use App\Models\PermohonanDokumen;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View|RedirectResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user && $user->role === 'keamanan') {
            return redirect()->route('keamanan.scanner');
        }

        $profile = $user ? $user->alumniProfile : null;
        if ($user && $user->role === 'koordinator' && ! $profile) {
            $profile = $user->alumniProfile()->create([
                'qr_identity_token' => 'IKLIMB-'.date('Y').'-'.strtoupper(Str::random(8)),
                'privacy_settings' => [
                    'show_wa' => true,
                    'show_address' => false,
                    'show_job' => true,
                    'show_education' => true,
                ],
            ]);
        }

        // Kabar pondok terbaru
        $kabarTerbaru = KabarPondok::whereNotNull('published_at')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        // Kunjungan aktif mendatang
        $kunjunganMendatang = null;
        if ($user) {
            $kunjunganMendatang = Kunjungan::where('user_id', $user->id)
                ->whereIn('status', ['menunggu', 'disetujui', 'dijadwalkan_ulang'])
                ->orderBy('tanggal_kunjungan', 'asc')
                ->first();
        }

        // Permohonan dokumen aktif
        $permohonanAktifCount = 0;
        if ($user) {
            $permohonanAktifCount = PermohonanDokumen::where('user_id', $user->id)
                ->whereNotIn('status', ['selesai', 'ditolak'])
                ->count();
        }

        return view('home', compact('user', 'profile', 'kabarTerbaru', 'kunjunganMendatang', 'permohonanAktifCount'));
    }
}
