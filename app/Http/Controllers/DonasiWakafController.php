<?php

namespace App\Http\Controllers;

use App\Models\DonasiPenyaluran;
use App\Models\DonasiProgram;
use App\Models\DonasiTransaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DonasiWakafController extends Controller
{
    public function index(): View
    {
        $programs = DonasiProgram::where('is_aktif', true)->latest()->get();
        $penyalurans = DonasiPenyaluran::with('program')->latest()->limit(5)->get();

        return view('donasi-wakaf.index', compact('programs', 'penyalurans'));
    }

    public function storeTransaksi(Request $request, int $id): RedirectResponse
    {
        $program = DonasiProgram::findOrFail($id);

        $validated = $request->validate([
            'nama_donatur' => ['required', 'string', 'max:100'],
            'nominal' => ['required', 'numeric', 'min:10000'],
            'no_wa_donatur' => ['nullable', 'string', 'max:30'],
            'doa_harapan' => ['nullable', 'string'],
            'is_anonim' => ['nullable', 'boolean'],
        ]);

        DonasiTransaksi::create([
            'donasi_program_id' => $program->id,
            'user_id' => Auth::id(),
            'nama_donatur' => $validated['nama_donatur'],
            'no_wa_donatur' => $validated['no_wa_donatur'] ?? null,
            'nominal' => $validated['nominal'],
            'is_anonim' => $request->boolean('is_anonim'),
            'doa_harapan' => $validated['doa_harapan'] ?? null,
            'status' => 'menunggu_konfirmasi',
        ]);

        // Auto increment program stats
        $program->increment('dana_terkumpul', $validated['nominal']);

        return back()->with('success', 'Alhamdulillah! Konfirmasi komitmen donasi Anda sebesar Rp '.number_format($validated['nominal'], 0, ',', '.').' telah tercatat.');
    }
}
