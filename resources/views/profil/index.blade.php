@extends('layouts.app')

@section('content')
<div class="space-y-5">

    <!-- Responsive Layout: 1 Column on Mobile, 2 Columns on Desktop -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 responsive-grid-2">
        
        <!-- Left Column: Header, Biodata & Logout -->
        <div class="lg:col-span-5 responsive-col-span-5 space-y-4">
            
            <!-- Profile Header Banner -->
            <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 text-white rounded-3xl p-5 shadow-lg relative overflow-hidden">
                <div class="flex items-center space-x-3.5 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-gold-400 text-slate-900 flex items-center justify-center font-black text-xl shadow-md border-2 border-white/60">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-white">{{ $user->name }}</h1>
                        <p class="text-xs text-emerald-200 mt-0.5">
                            NIS: <span class="font-mono font-bold text-gold-300">{{ $profile->nis ?? '-' }}</span>
                        </p>
                        <div class="flex items-center space-x-1.5 mt-1">
                            <span class="px-2 py-0.5 rounded-full bg-emerald-700/80 text-emerald-100 text-[10px] font-semibold border border-emerald-600">
                                {{ $profile->angkatan ?? 'Alumni' }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full bg-gold-400/20 text-gold-300 text-[10px] font-semibold border border-gold-400/30">
                                {{ $user->status === 'aktif' ? 'Terverifikasi' : 'Menunggu' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-emerald-700/60 flex items-center justify-between">
                    <span class="text-xs text-emerald-200">Kartu Digital Alumni:</span>
                    <a href="{{ route('kartu-alumni') }}" class="py-1.5 px-3 bg-gold-400 hover:bg-gold-500 text-slate-950 font-bold text-xs rounded-xl shadow flex items-center space-x-1.5 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        <span>Lihat Kartu QR Resmi</span>
                    </a>
                </div>
            </div>

            <!-- Biodata Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm space-y-3">
                <div class="flex items-center justify-between border-b pb-2">
                    <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Biodata & Santri</span>
                    </h2>
                    <a href="{{ route('onboarding.index') }}" class="text-xs text-emerald-700 hover:underline font-semibold">
                        Edit Data &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-400 block">Tempat, Tanggal Lahir</span>
                        <span class="font-semibold text-slate-800">
                            {{ $profile->tempat_lahir ?? '-' }}, {{ $profile->tanggal_lahir ? $profile->tanggal_lahir->format('d M Y') : '-' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Jenjang Pondok</span>
                        <span class="font-semibold text-slate-800">{{ $profile->jenjang_pondok ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">WhatsApp</span>
                        <span class="font-mono font-semibold text-slate-800">{{ $user->no_wa }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Status Pernikahan</span>
                        <span class="font-semibold text-slate-800">{{ $profile->status_pernikahan ?? '-' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-[10px] text-slate-400 block">Domisili</span>
                        <span class="font-semibold text-slate-800">
                            {{ $profile->kabupaten_kota ?? '-' }}, {{ $profile->provinsi ?? '-' }} ({{ $profile->negara ?? 'Indonesia' }})
                        </span>
                    </div>
                </div>
            </div>

            <!-- Logout CTA -->
            <div class="pt-1">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-slate-200 hover:bg-rose-100 text-slate-700 hover:text-rose-700 font-bold text-xs transition flex items-center justify-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar dari Akun (Logout)</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- Right Column: Pekerjaan, Pendidikan & Privasi -->
        <div class="lg:col-span-7 responsive-col-span-7 space-y-4">
            
            <!-- Riwayat Pekerjaan -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm space-y-2">
                <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center space-x-1.5 border-b pb-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Profesi / Pekerjaan Saat Ini</span>
                </h2>
                <div class="text-xs space-y-1">
                    <div class="font-bold text-slate-800 text-sm">{{ $profile->pekerjaan_lembaga ?? 'Belum diisi' }}</div>
                    <div class="text-slate-600">{{ $profile->pekerjaan_jabatan ?? '-' }} &bull; <span class="text-emerald-700 font-medium">{{ $profile->pekerjaan_divisi ?? '-' }}</span></div>
                </div>
            </div>

            <!-- Riwayat Pendidikan Tinggi -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm space-y-3">
                <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center space-x-1.5 border-b pb-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                    <span>Riwayat Pendidikan Tinggi</span>
                </h2>

                <div class="space-y-2">
                    @forelse($profile->educations as $edu)
                        <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 flex items-start justify-between text-xs">
                            <div>
                                <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]">{{ $edu->jenjang }}</span>
                                <div class="font-bold text-slate-800 mt-1">{{ $edu->nama_universitas }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $edu->program_studi }}</div>
                            </div>
                            <span class="font-mono text-xs text-slate-500 font-semibold">Lulus {{ $edu->tahun_lulus }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 italic">Belum ada data riwayat pendidikan tinggi.</p>
                    @endforelse
                </div>
            </div>

            <!-- Pengaturan Privasi (Direktori Alumni) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm space-y-3">
                <div class="border-b pb-2">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span>Pengaturan Privasi Direktori Alumni</span>
                    </h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">Pilih data mana yang ingin Anda tampilkan kepada sesama alumni di Direktori.</p>
                </div>

                <form action="{{ route('profil.privacy') }}" method="POST" class="space-y-2 text-xs">
                    @csrf
                    <label class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 cursor-pointer">
                        <span class="text-slate-700 font-medium">Tampilkan Nomor WhatsApp</span>
                        <input type="checkbox" name="show_wa" value="1" {{ $profile->canShowWa() ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                    </label>
                    <label class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 cursor-pointer">
                        <span class="text-slate-700 font-medium">Tampilkan Alamat Domisili</span>
                        <input type="checkbox" name="show_address" value="1" {{ $profile->canShowAddress() ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                    </label>
                    <label class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 cursor-pointer">
                        <span class="text-slate-700 font-medium">Tampilkan Tempat Kerja & Divisi</span>
                        <input type="checkbox" name="show_job" value="1" {{ $profile->canShowJob() ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                    </label>
                    <label class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 cursor-pointer">
                        <span class="text-slate-700 font-medium">Tampilkan Riwayat Pendidikan</span>
                        <input type="checkbox" name="show_education" value="1" {{ $profile->canShowEducation() ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                    </label>

                    <button type="submit" class="w-full py-2 px-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Simpan Preferensi Privasi
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
