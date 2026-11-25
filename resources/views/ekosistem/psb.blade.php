@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <div class="flex items-center space-x-2 border-b pb-3 border-slate-200">
        <a href="{{ route('home') }}" class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">&larr;</a>
        <div>
            <h1 class="text-base font-extrabold text-slate-800">PSB Jalur Khusus Alumni</h1>
            <p class="text-xs text-slate-500">Pendaftaran santri baru untuk putra-putri & kerabat alumni.</p>
        </div>
    </div>

    <!-- Active Applications -->
    @if($myPsb->isNotEmpty())
        <div class="space-y-2">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Pantauan Pendaftaran</h2>
            @foreach($myPsb as $p)
                <div class="p-3 bg-white rounded-2xl border border-slate-200 shadow-sm text-xs space-y-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-mono text-[10px] text-slate-400 font-bold block">{{ $p->nomor_registrasi }}</span>
                            <h3 class="font-bold text-slate-800">{{ $p->nama_calon_santri }}</h3>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800">
                            {{ str_replace('_', ' ', $p->status_seleksi) }}
                        </span>
                    </div>
                    <div class="text-slate-500 text-[11px]">
                        Pilihan: {{ $p->jenjang_pilihan }} &bull; Hubungan: {{ $p->hubungan_keluarga }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Registration Form -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-3">
        <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider border-b pb-2">+ Formulir Pendaftaran Calon Santri</h2>

        <form action="{{ route('psb-alumni.store') }}" method="POST" class="space-y-3 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Nama Calon Santri <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_calon_santri" required placeholder="Nama lengkap anak / kerabat"
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Hubungan Keluarga <span class="text-rose-500">*</span></label>
                    <select name="hubungan_keluarga" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                        <option value="Anak Kandung">Anak Kandung</option>
                        <option value="Adik Kandung">Adik Kandung</option>
                        <option value="Keponakan">Keponakan</option>
                        <option value="Kerabat">Kerabat Dekat</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                        <option value="Laki-laki">Laki-laki (Santriwan)</option>
                        <option value="Perempuan">Perempuan (Santriwati)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" required placeholder="Kota lahir"
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Jenjang Pendidikan yang Dituju <span class="text-rose-500">*</span></label>
                <select name="jenjang_pilihan" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                    <option value="Madrasah Tsanawiyah (MTs PPIB)">Madrasah Tsanawiyah (MTs PPIB)</option>
                    <option value="Madrasah Aliyah (MA PPIB)">Madrasah Aliyah (MA PPIB)</option>
                    <option value="Takhasus Tahfizh Al-Qur'an">Takhasus Tahfizh Al-Qur'an 30 Juz</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow transition">
                Daftarkan Calon Santri &rarr;
            </button>
        </form>
    </div>
</div>
@endsection
