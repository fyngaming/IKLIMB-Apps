<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AlumniEducation;
use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function index(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $profile = $user->alumniProfile;

        return view('auth.onboarding', compact('user', 'profile'));
    }

    public function store(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'angkatan' => ['required', 'string', 'max:50'],
            'jenjang_pondok' => ['required', 'string', 'max:50'],
            'alamat_lengkap' => ['nullable', 'string'],
            'kabupaten_kota' => ['required', 'string', 'max:100'],
            'provinsi' => ['required', 'string', 'max:100'],
            'negara' => ['required', 'string', 'max:100'],
            'status_pernikahan' => ['required', 'in:Belum Menikah,Menikah,Cerai'],
            'pekerjaan_lembaga' => ['nullable', 'string', 'max:150'],
            'pekerjaan_divisi' => ['nullable', 'string', 'max:150'],
            'pekerjaan_jabatan' => ['nullable', 'string', 'max:150'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'educations' => ['nullable', 'array'],
            'educations.*.jenjang' => ['required', 'in:D3,D4,S1,S2,S3'],
            'educations.*.nama_universitas' => ['required', 'string', 'max:150'],
            'educations.*.program_studi' => ['required', 'string', 'max:150'],
            'educations.*.tahun_lulus' => ['required', 'numeric', 'min:1980', 'max:'.(date('Y') + 5)],
        ], [
            'kabupaten_kota.required' => 'Kabupaten/Kota domisili wajib diisi.',
            'provinsi.required' => 'Provinsi domisili wajib diisi.',
            'status_pernikahan.required' => 'Status pernikahan wajib dipilih.',
            'educations.*.nama_universitas.required' => 'Nama universitas/kampus wajib diisi.',
            'educations.*.program_studi.required' => 'Program studi wajib diisi.',
            'educations.*.tahun_lulus.required' => 'Tahun kelulusan wajib diisi.',
        ]);

        DB::transaction(function () use ($user, $validated) {
            // Update User details
            $userData = ['name' => $validated['name']];
            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            $userData['is_first_login'] = false;
            $user->update($userData);

            // Update AlumniProfile
            $profile = $user->alumniProfile;
            if ($profile) {
                $profile->update([
                    'tempat_lahir' => $validated['tempat_lahir'] ?? $profile->tempat_lahir,
                    'tanggal_lahir' => $validated['tanggal_lahir'] ?? $profile->tanggal_lahir,
                    'angkatan' => $validated['angkatan'],
                    'jenjang_pondok' => $validated['jenjang_pondok'],
                    'alamat_lengkap' => $validated['alamat_lengkap'] ?? null,
                    'kabupaten_kota' => $validated['kabupaten_kota'],
                    'provinsi' => $validated['provinsi'],
                    'negara' => $validated['negara'],
                    'status_pernikahan' => $validated['status_pernikahan'],
                    'pekerjaan_lembaga' => $validated['pekerjaan_lembaga'] ?? null,
                    'pekerjaan_divisi' => $validated['pekerjaan_divisi'] ?? null,
                    'pekerjaan_jabatan' => $validated['pekerjaan_jabatan'] ?? null,
                ]);

                // Sync Educations
                $profile->educations()->delete();
                if (! empty($validated['educations'])) {
                    foreach ($validated['educations'] as $edu) {
                        if (! empty($edu['nama_universitas'])) {
                            AlumniEducation::create([
                                'alumni_profile_id' => $profile->id,
                                'jenjang' => $edu['jenjang'],
                                'nama_universitas' => $edu['nama_universitas'],
                                'program_studi' => $edu['program_studi'],
                                'tahun_lulus' => $edu['tahun_lulus'],
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('home')->with('success', 'Alhamdulillah! Biodata dan profil alumni Anda berhasil diperbarui.');
    }
}
