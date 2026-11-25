<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'no_wa' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Standardize nomor WA: remove leading + or replace 62 with 0 if necessary
        $noWa = preg_replace('/[^0-9]/', '', $credentials['no_wa']);
        if (str_starts_with($noWa, '62')) {
            $noWa = '0'.substr($noWa, 2);
        }

        $user = User::where('no_wa', $noWa)->first();

        if (! $user) {
            // Also try exact string as fallback
            $user = User::where('no_wa', $credentials['no_wa'])->first();
        }

        if (! $user || ! password_verify($credentials['password'], $user->password)) {
            return back()->withInput()->withErrors([
                'no_wa' => 'Nomor WhatsApp atau password tidak sesuai.',
            ]);
        }

        if ($user->status === 'ditolak') {
            return back()->withErrors([
                'no_wa' => 'Akun pendaftaran Anda tidak disetujui. Hubungi pengurus IKLIMB.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($user->role === 'alumni' && $user->status === 'menunggu_verifikasi') {
            return redirect()->route('verification.notice');
        }

        if ($user->role === 'alumni' && $user->is_first_login) {
            return redirect()->route('onboarding.index');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'keamanan') {
            return redirect()->route('keamanan.scanner');
        }

        return redirect()->intended(route('home'));
    }

    public function quickLogin(string $role): RedirectResponse
    {
        $user = User::where('role', $role)->first();
        if (! $user) {
            return back()->with('error', "Akun role {$role} belum ditemukan.");
        }

        Auth::login($user);
        request()->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', "Berhasil masuk sebagai demo admin ({$user->name}).");
        }

        if ($user->role === 'keamanan') {
            return redirect()->route('keamanan.scanner');
        }

        if ($user->is_first_login) {
            return redirect()->route('onboarding.index');
        }

        return redirect()->route('home')->with('success', "Berhasil masuk sebagai demo {$user->role} ({$user->name}).");
    }

    public function logout(Request $request): RedirectResponse
    {
        /** @var StatefulGuard $guard */
        $guard = Auth::guard('web');
        $guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar.');
    }
}
