<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function index(): View
    {
        $pendingUsers = User::with(['alumniProfile.masterSantri'])
            ->where('role', 'alumni')
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->paginate(15);

        $verifiedUsers = User::with(['alumniProfile'])
            ->where('role', 'alumni')
            ->where('status', 'aktif')
            ->latest()
            ->limit(10)
            ->get();

        return view('koordinator.verifikasi', compact('pendingUsers', 'verifiedUsers'));
    }

    public function approve(Request $request, int $id): RedirectResponse
    {
        $user = User::with('alumniProfile')->findOrFail($id);

        if ($user->status === 'aktif') {
            return back()->with('info', 'Alumni ini sudah terverifikasi sebelumnya.');
        }

        // Generate activation token valid for 7 days
        $token = Str::random(48);
        $user->update([
            'activation_token' => $token,
            'activation_expires_at' => now()->addDays(7),
        ]);

        $activationUrl = route('activation.form', ['token' => $token]);

        // Mode Simulasi Log & Preview Link
        Log::info("SIMULASI NOTIFIKASI WA AKTIVASI IKLIMB: Kepada {$user->name} ({$user->no_wa}). Link Aktivasi: {$activationUrl}");

        return back()->with('activation_generated', [
            'name' => $user->name,
            'no_wa' => $user->no_wa,
            'url' => $activationUrl,
            'message' => "Pendaftaran alumni {$user->name} berhasil disetujui! Link aktivasi telah diterbitkan.",
        ]);
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'ditolak']);

        return back()->with('info', "Pendaftaran alumni {$user->name} telah ditolak.");
    }
}
