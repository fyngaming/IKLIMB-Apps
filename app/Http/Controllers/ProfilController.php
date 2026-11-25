<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProfilController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->alumniProfile()->with('educations')->firstOrCreate([
            'user_id' => $user->id,
        ], [
            'qr_identity_token' => 'IKLIMB-'.date('Y').'-'.strtoupper(Str::random(8)),
            'privacy_settings' => [
                'show_wa' => true,
                'show_address' => false,
                'show_job' => true,
                'show_education' => true,
            ],
        ]);

        return view('profil.index', compact('user', 'profile'));
    }

    public function kartuAlumni(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Petugas Keamanan dan Admin tidak memerlukan Kartu Alumni QR
        if ($user->role === 'keamanan') {
            return redirect()->route('keamanan.scanner')->with('info', 'Petugas Keamanan bertugas memindai kode QR pengunjung melalui Scanner Pos.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('info', 'Akun Administrator mengelola seluruh modul sistem melalui Panel Kontrol Admin.');
        }

        $profile = $user->alumniProfile;

        if (! $profile) {
            if ($user->role === 'koordinator') {
                $profile = $user->alumniProfile()->create([
                    'qr_identity_token' => 'IKLIMB-'.date('Y').'-'.strtoupper(Str::random(8)),
                    'privacy_settings' => [
                        'show_wa' => true,
                        'show_address' => false,
                        'show_job' => true,
                        'show_education' => true,
                    ],
                ]);
            } else {
                return redirect()->route('onboarding.index');
            }
        }

        // Generate pure SVG QR code string
        $qrSvg = QrCode::size(200)
            ->color(6, 78, 59) // Dark emerald
            ->backgroundColor(255, 255, 255)
            ->margin(1)
            ->generate($profile->qr_identity_token);

        return view('profil.kartu-alumni', compact('user', 'profile', 'qrSvg'));
    }

    public function updatePrivacy(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->alumniProfile;

        if ($profile) {
            $profile->update([
                'privacy_settings' => [
                    'show_wa' => $request->boolean('show_wa'),
                    'show_address' => $request->boolean('show_address'),
                    'show_job' => $request->boolean('show_job'),
                    'show_education' => $request->boolean('show_education'),
                ],
            ]);
        }

        return back()->with('success', 'Pengaturan privasi data alumni Anda berhasil diperbarui.');
    }
}
