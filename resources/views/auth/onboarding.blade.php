@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4" x-data="onboardingForm()">
    <!-- Banner -->
    <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 text-white p-4 rounded-2xl shadow-md">
        <span class="px-2 py-0.5 rounded-full bg-gold-400 text-slate-900 text-[10px] font-bold uppercase tracking-wider">
            Langkah 1 Kali
        </span>
        <h1 class="text-base font-extrabold text-white mt-1">Lengkapi Profil Alumni</h1>
        <p class="text-xs text-emerald-200 mt-0.5 leading-relaxed">
            Harap perbarui biodata, alamat, riwayat pendidikan, dan profesi Anda untuk mengaktifkan kartu alumni digital serta jejaring IKLIMB.
        </p>
    </div>

    @if ($errors->any())
        <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl">
            <div class="font-bold mb-1">Periksa isian Anda:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('onboarding.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- 1. Biodata & Alamat -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center space-x-1.5 border-b pb-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>1. Biodata & Alamat Domisili</span>
            </h2>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $profile->tempat_lahir ?? '') }}" placeholder="Kota Lahir"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($profile->tanggal_lahir)->format('Y-m-d') ?? '') }}"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Angkatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="angkatan" value="{{ old('angkatan', $profile->angkatan ?? '') }}" required placeholder="Contoh: 2015"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenjang di Pondok <span class="text-rose-500">*</span></label>
                    <select name="jenjang_pondok" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                        @foreach(['Madrasah Aliyah (MA)', 'Madrasah Tsanawiyah (MTs)', 'SMA PPIB', 'Takhasus Tahfizh', 'Kulliyatul Muallimin'] as $j)
                            <option value="{{ $j }}" {{ old('jenjang_pondok', $profile->jenjang_pondok ?? '') === $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kabupaten / Kota <span class="text-rose-500">*</span></label>
                    <input type="text" name="kabupaten_kota" value="{{ old('kabupaten_kota', $profile->kabupaten_kota ?? 'Jakarta Selatan') }}" required
                        placeholder="Contoh: Surabaya"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Provinsi <span class="text-rose-500">*</span></label>
                    <input type="text" name="provinsi" value="{{ old('provinsi', $profile->provinsi ?? 'DKI Jakarta') }}" required
                        placeholder="Contoh: Jawa Timur"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Negara <span class="text-rose-500">*</span></label>
                    <input type="text" name="negara" value="{{ old('negara', $profile->negara ?? 'Indonesia') }}" required
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Pernikahan <span class="text-rose-500">*</span></label>
                    <select name="status_pernikahan" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                        <option value="Belum Menikah" {{ old('status_pernikahan', $profile->status_pernikahan ?? '') === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Menikah" {{ old('status_pernikahan', $profile->status_pernikahan ?? '') === 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Cerai" {{ old('status_pernikahan', $profile->status_pernikahan ?? '') === 'Cerai' ? 'selected' : '' }}>Cerai</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" rows="2" placeholder="Nama jalan, RT/RW, Kecamatan, dsb."
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">{{ old('alamat_lengkap', $profile->alamat_lengkap ?? '') }}</textarea>
            </div>
        </div>

        <!-- 2. Riwayat Pendidikan Dinamis -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between border-b pb-2">
                <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    <span>2. Riwayat Pendidikan Tinggi (Dinamis)</span>
                </h2>
                <button type="button" @click="addEducation()" class="px-2.5 py-1 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-800 text-xs font-bold flex items-center space-x-1 transition">
                    <span class="text-sm">+</span>
                    <span>Tambah Baris</span>
                </button>
            </div>

            <template x-for="(edu, index) in educations" :key="index">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-2 relative">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-500" x-text="'Pendidikan #' + (index + 1)"></span>
                        <button type="button" @click="removeEducation(index)" x-show="educations.length > 1" class="text-rose-500 hover:text-rose-700 text-xs font-bold px-1.5 py-0.5 rounded hover:bg-rose-50">
                            &times; Hapus
                        </button>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Jenjang</label>
                            <select :name="'educations[' + index + '][jenjang]'" x-model="edu.jenjang" class="w-full px-2 py-1.5 text-xs bg-white border border-slate-300 rounded-lg">
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Nama Universitas / Institut</label>
                            <input type="text" :name="'educations[' + index + '][nama_universitas]'" x-model="edu.nama_universitas" required placeholder="Contoh: UIN Syarif Hidayatullah"
                                class="w-full px-2 py-1.5 text-xs bg-white border border-slate-300 rounded-lg">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-2">
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Program Studi / Jurusan</label>
                            <input type="text" :name="'educations[' + index + '][program_studi]'" x-model="edu.program_studi" required placeholder="Contoh: Perbankan Syariah"
                                class="w-full px-2 py-1.5 text-xs bg-white border border-slate-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Tahun Lulus</label>
                            <input type="number" :name="'educations[' + index + '][tahun_lulus]'" x-model="edu.tahun_lulus" required placeholder="2020"
                                class="w-full px-2 py-1.5 text-xs bg-white border border-slate-300 rounded-lg">
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- 3. Riwayat Pekerjaan -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center space-x-1.5 border-b pb-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>3. Riwayat Pekerjaan / Usaha</span>
            </h2>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lembaga / Perusahaan / Instansi</label>
                <input type="text" name="pekerjaan_lembaga" value="{{ old('pekerjaan_lembaga', $profile->pekerjaan_lembaga ?? '') }}"
                    placeholder="Contoh: PT. Barakah Amanah / Pesantren / Freelance"
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Divisi / Bidang Kerja</label>
                    <input type="text" name="pekerjaan_divisi" value="{{ old('pekerjaan_divisi', $profile->pekerjaan_divisi ?? '') }}"
                        placeholder="Contoh: IT, Pendidikan, Dakwah"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jabatan / Posisi</label>
                    <input type="text" name="pekerjaan_jabatan" value="{{ old('pekerjaan_jabatan', $profile->pekerjaan_jabatan ?? '') }}"
                        placeholder="Contoh: Software Engineer / Pengajar"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <!-- 4. Keamanan & Konfirmasi Sandi -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center space-x-1.5 border-b pb-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>4. Keamanan Akun</span>
            </h2>
            <p class="text-[11px] text-slate-500">Kosongkan jika tidak ingin mengubah kata sandi yang sudah Anda buat saat aktivasi.</p>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Ubah Kata Sandi</label>
                    <input type="password" name="password" minlength="6" placeholder="Opsional"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" minlength="6" placeholder="Opsional"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 hover:to-emerald-800 text-white font-bold text-sm shadow-lg transition transform active:scale-95">
            Simpan & Buka Akses IKLIMB Apps &rarr;
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function onboardingForm() {
        var currentYear = (new Date()).getFullYear().toString();
        return {
            educations: [
                {
                    jenjang: 'S1',
                    nama_universitas: '',
                    program_studi: '',
                    tahun_lulus: currentYear
                }
            ],
            addEducation: function () {
                this.educations.push({
                    jenjang: 'S1',
                    nama_universitas: '',
                    program_studi: '',
                    tahun_lulus: currentYear
                });
            },
            removeEducation: function (index) {
                if (this.educations.length > 1) {
                    this.educations.splice(index, 1);
                }
            }
        };
    }
</script>
@endpush
