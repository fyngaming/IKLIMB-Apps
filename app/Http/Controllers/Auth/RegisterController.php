<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AlumniProfile;
use App\Models\MasterSantri;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'no_wa' => ['required', 'string', 'min:9', 'max:20'],
            'nis' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
        ], [
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'nis.required' => 'NIS saat santri wajib diisi.',
            'name.required' => 'Nama lengkap wajib diisi.',
        ]);

        // Clean WhatsApp format
        $noWa = preg_replace('/[^0-9]/', '', $validated['no_wa']);
        if (str_starts_with($noWa, '62')) {
            $noWa = '0'.substr($noWa, 2);
        }

        $nisInput = trim($validated['nis']);

        // Check if master_santri has this NIS
        $master = MasterSantri::where('nis', $nisInput)->first();
        if (! $master) {
            return back()->withInput()->withErrors([
                'nis' => "NIS '{$nisInput}' tidak ditemukan dalam Master Data Santri PPIB. Pastikan penulisan NIS benar atau hubungi admin PPIB.",
            ]);
        }

        // Check if already registered
        if ($master->is_registered || User::where('no_wa', $noWa)->exists() || AlumniProfile::where('nis', $nisInput)->exists()) {
            return back()->withInput()->withErrors([
                'nis' => 'Data santri atau nomor WhatsApp ini sudah terdaftar sebelumnya. Silakan login atau hubungi Koordinator IKLIMB jika lupa kata sandi.',
            ]);
        }

        // Create User and AlumniProfile in transaction
        $user = DB::transaction(function () use ($validated, $noWa, $master) {
            $user = User::create([
                'name' => $validated['name'],
                'no_wa' => $noWa,
                'email' => null,
                'password' => bcrypt(Str::random(16)), // temporary until activation
                'role' => 'alumni',
                'status' => 'menunggu_verifikasi',
                'is_first_login' => true,
            ]);

            $master->update(['is_registered' => true]);

            $qrToken = 'IKLIMB-'.date('Y').'-'.strtoupper(Str::random(8));

            AlumniProfile::create([
                'user_id' => $user->id,
                'master_santri_id' => $master->id,
                'nis' => $master->nis,
                'qr_identity_token' => $qrToken,
                'angkatan' => $master->angkatan,
                'jenjang_pondok' => $master->jenjang_pondok,
                'tempat_lahir' => $master->tempat_lahir,
                'tanggal_lahir' => $master->tanggal_lahir,
                'privacy_settings' => [
                    'show_wa' => true,
                    'show_address' => false,
                    'show_job' => true,
                    'show_education' => true,
                ],
            ]);

            return $user;
        });

        return redirect()->route('register.success', ['id' => $user->id]);
    }

    public function success(int $id): View|RedirectResponse
    {
        $user = User::with(['alumniProfile.masterSantri'])->findOrFail($id);

        return view('auth.register-success', compact('user'));
    }

    public function verificationNotice(): View
    {
        $user = auth()->user();

        return view('auth.verification-notice', compact('user'));
    }
}
