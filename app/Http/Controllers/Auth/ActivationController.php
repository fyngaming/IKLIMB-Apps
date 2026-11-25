<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ActivationController extends Controller
{
    public function showActivationForm(string $token): View|RedirectResponse
    {
        $user = User::with('alumniProfile')->where('activation_token', $token)->first();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Tautan aktivasi tidak valid atau telah kedaluwarsa.');
        }

        if ($user->activation_expires_at && $user->activation_expires_at->isPast()) {
            return redirect()->route('login')->with('error', 'Tautan aktivasi telah kedaluwarsa. Silakan hubungi Koordinator IKLIMB.');
        }

        return view('auth.activation', compact('user', 'token'));
    }

    public function submitActivation(Request $request, string $token): RedirectResponse
    {
        $user = User::where('activation_token', $token)->first();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Tautan aktivasi tidak valid.');
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
            'status' => 'aktif',
            'activation_token' => null,
            'activation_expires_at' => null,
            'is_first_login' => true, // Ensure they complete onboarding next
        ]);

        // Auto login
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('onboarding.index')->with('success', 'Akun IKLIMB Anda berhasil diaktifkan! Silakan lengkapi profil Anda.');
    }
}
