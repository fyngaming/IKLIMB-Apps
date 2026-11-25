@extends('layouts.auth')

@section('content')
<div class="space-y-4">
    <div class="text-center">
        <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold tracking-wide uppercase">
            Pendaftaran Alumni
        </span>
        <h2 class="text-lg font-bold text-slate-800 mt-2">Integrasi Data Santri PPIB</h2>
        <p class="text-xs text-slate-500 mt-1">Masukkan data valid saat Anda masih berstatus santri di Pondok Pesantren PPIB.</p>
    </div>

    <!-- Verification Info Banner -->
    <div class="p-3 bg-emerald-50/70 border border-emerald-200 rounded-xl text-xs text-emerald-900 space-y-1">
        <div class="font-bold flex items-center space-x-1.5 text-emerald-800">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Alur Verifikasi Otomatis</span>
        </div>
        <p class="text-[11px] text-emerald-700 leading-relaxed">
            Sistem mencocokkan NIS Anda ke Master Santri PPIB. Setelah data cocok, akun Anda akan diverifikasi oleh Koordinator IKLIMB sebelum mendapatkan link aktivasi kata sandi.
        </p>
    </div>

    <form action="{{ route('register.submit') }}" method="POST" class="space-y-3.5">
        @csrf
        <div>
            <label for="no_wa" class="block text-xs font-semibold text-slate-700 mb-1">
                Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}" required
                    placeholder="Contoh: 081234567890"
                    class="w-full pl-9 pr-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <p class="text-[10px] text-slate-500 mt-1">Digunakan untuk login dan menerima link aktivasi.</p>
        </div>

        <div>
            <label for="nis" class="block text-xs font-semibold text-slate-700 mb-1">
                NIS (Nomor Induk Santri PPIB) <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                </div>
                <input type="text" name="nis" id="nis" value="{{ old('nis') }}" required
                    placeholder="Contoh: PPIB-2015-089"
                    class="w-full pl-9 pr-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 uppercase">
            </div>
            <p class="text-[10px] text-slate-500 mt-1">NIS tercantum di ijazah/rapor pondok pesantren PPIB.</p>
        </div>

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">
                Nama Lengkap (Sesuai Ijazah) <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    placeholder="Nama lengkap tanpa singkatan"
                    class="w-full pl-9 pr-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
        </div>

        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 hover:to-emerald-800 text-white font-bold text-sm shadow-md transition transform active:scale-95">
            Daftar & Hubungkan ke Master Santri
        </button>
    </form>

    <div class="text-center pt-2">
        <p class="text-xs text-slate-600">
            Sudah memiliki akun aktif?
            <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:underline">
                Masuk di sini
            </a>
        </p>
    </div>
</div>
@endsection
