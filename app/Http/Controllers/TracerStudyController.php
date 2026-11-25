<?php

namespace App\Http\Controllers;

use App\Models\TracerStudy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TracerStudyController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $myTracer = TracerStudy::where('user_id', $user->id)->latest()->first();

        $stats = [
            'total' => TracerStudy::count(),
            'bekerja' => TracerStudy::where('status_kiprah', 'Bekerja')->count(),
            'wirausaha' => TracerStudy::where('status_kiprah', 'Wirausaha')->count(),
            'studi_lanjut' => TracerStudy::where('status_kiprah', 'Studi Lanjut')->count(),
            'dakwah' => TracerStudy::where('status_kiprah', 'Dakwah / Pengabdian')->count(),
        ];

        return view('tracer-study.index', compact('myTracer', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'status_kiprah' => ['required', 'in:Bekerja,Wirausaha,Studi Lanjut,Dakwah / Pengabdian,Mencari Kerja'],
            'nama_instansi' => ['nullable', 'string', 'max:150'],
            'pendapatan_rata_rata' => ['nullable', 'string', 'max:50'],
            'keselarasan_ilmu' => ['nullable', 'in:Sangat Selaras,Cukup Selaras,Kurang Selaras'],
            'kontribusi_pondok_feedback' => ['nullable', 'string'],
            'saran_kurikulum' => ['nullable', 'string'],
        ]);

        TracerStudy::updateOrCreate(
            ['user_id' => Auth::id(), 'tahun_survey' => date('Y')],
            $validated
        );

        return back()->with('success', 'Jazakumullah khairan! Partisipasi Tracer Study Anda berhasil disimpan.');
    }
}
