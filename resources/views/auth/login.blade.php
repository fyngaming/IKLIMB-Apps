@extends('layouts.auth')

@section('content')
<div class="space-y-5">
    <div class="text-center">
        <h2 class="text-lg font-bold text-slate-800">Assalamu'alaikum, Alumni!</h2>
        <p class="text-xs text-slate-500 mt-1">Silakan masuk menggunakan nomor WhatsApp dan kata sandi Anda.</p>
    </div>

    <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="no_wa" class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}" required autofocus
                    placeholder="Contoh: 081234567890"
                    class="w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi</label>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input :type="show ? 'text' : 'password'" name="password" id="password" required
                    placeholder="Masukkan kata sandi"
                    class="w-full pl-9 pr-10 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 text-xs">
                    <span x-text="show ? 'Sembunyi' : 'Lihat'"></span>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                <span>Ingat Saya</span>
            </label>
            <a href="https://wa.me/6281234567891?text=Halo%20Admin%20IKLIMB,%20saya%20lupa%20kata%20sandi%20akun%20saya" target="_blank" class="text-emerald-700 hover:text-emerald-800 font-semibold">
                Lupa Sandi?
            </a>
        </div>

        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 hover:to-emerald-800 text-white font-bold text-sm shadow-md transition transform active:scale-95">
            Masuk ke IKLIMB Apps
        </button>
    </form>

    <div class="text-center pt-2 border-t border-slate-100">
        <p class="text-xs text-slate-600">
            Belum terdaftar sebagai anggota IKLIMB?
            <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:underline block mt-1">
                Daftar dengan NIS Santri PPIB &rarr;
            </a>
        </p>
    </div>

    <!-- Quick Role Tester Widget -->
    <div class="mt-4 p-3.5 bg-slate-50/90 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-2.5 pb-2 border-b border-slate-200/80">
            <span class="text-[11px] font-extrabold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span>Mode Demo / Uji Coba Cepat</span>
            </span>
            <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100/90 px-2 py-0.5 rounded-full border border-emerald-300/80">
                1-Klik Langsung Masuk
            </span>
        </div>
        <div class="grid grid-cols-2 gap-2 text-xs">
            <a href="{{ route('login.quick', 'admin') }}" class="px-3 py-2.5 bg-slate-900 hover:bg-black text-white rounded-xl font-bold text-center shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center space-x-2 active:scale-95 border border-slate-700/80">
                <svg class="w-4 h-4 text-gold-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span class="font-bold text-white tracking-tight">Super Admin</span>
            </a>
            <a href="{{ route('login.quick', 'koordinator') }}" class="px-3 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl font-bold text-center shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center space-x-2 active:scale-95 border border-emerald-600/80">
                <svg class="w-4 h-4 text-emerald-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="font-bold text-white tracking-tight">Koordinator</span>
            </a>
            <a href="{{ route('login.quick', 'keamanan') }}" class="px-3 py-2.5 bg-sky-900 hover:bg-sky-950 text-white rounded-xl font-bold text-center shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center space-x-2 active:scale-95 border border-sky-700/80">
                <svg class="w-4 h-4 text-sky-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-bold text-white tracking-tight">Pos Keamanan</span>
            </a>
            <a href="{{ route('login.quick', 'alumni') }}" class="px-3 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-center shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center space-x-2 active:scale-95 border border-emerald-500/80">
                <svg class="w-4 h-4 text-emerald-100 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                <span class="font-bold text-white tracking-tight">Alumni Aktif</span>
            </a>
        </div>
    </div>
</div>
@endsection
