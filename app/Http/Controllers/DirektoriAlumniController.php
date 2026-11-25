<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirektoriAlumniController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');
        $angkatan = $request->query('angkatan');
        $kota = $request->query('kota');

        $query = User::with(['alumniProfile.educations'])
            ->where('role', 'alumni')
            ->where('status', 'aktif')
            ->whereHas('alumniProfile');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('alumniProfile', function ($p) use ($search) {
                        $p->where('pekerjaan_lembaga', 'like', "%{$search}%")
                            ->orWhere('pekerjaan_divisi', 'like', "%{$search}%")
                            ->orWhere('kabupaten_kota', 'like', "%{$search}%");
                    });
            });
        }

        if ($angkatan) {
            $query->whereHas('alumniProfile', fn ($p) => $p->where('angkatan', $angkatan));
        }

        if ($kota) {
            $query->whereHas('alumniProfile', fn ($p) => $p->where('kabupaten_kota', 'like', "%{$kota}%"));
        }

        $alumniList = $query->paginate(12);

        $angkatanList = AlumniProfile::whereNotNull('angkatan')->distinct()->pluck('angkatan');
        $kotaList = AlumniProfile::whereNotNull('kabupaten_kota')->distinct()->pluck('kabupaten_kota');

        return view('direktori-alumni.index', compact('alumniList', 'angkatanList', 'kotaList', 'search', 'angkatan', 'kota'));
    }
}
