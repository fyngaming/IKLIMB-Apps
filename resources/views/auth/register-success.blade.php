@extends('layouts.auth')

@section('content')
<div class="space-y-4 text-center">
    <!-- Success Icon -->
    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center ring-8 ring-emerald-50">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    </div>

    <div>
        <h2 class="text-lg font-extrabold text-slate-800">Alhamdulillah, Data Cocok!</h2>
        <p class="text-xs text-slate-500 mt-0.5">Pendaftaran Anda berhasil terhubung dengan Master Santri PPIB.</p>
    </div>

    <!-- Integrated Alumni Profile Card Preview -->
    <div class="bg-gradient-to-br from-emerald-900 to-emerald-800 text-white p-4 rounded-2xl shadow-xl text-left relative overflow-hidden border border-gold-400/40">
        <!-- Watermark Emblem -->
        <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/5 pointer-events-none"></div>

        <div class="flex items-center justify-between pb-3 border-b border-emerald-700/60">
            <div>
                <span class="text-[10px] text-gold-300 font-bold uppercase tracking-wider">Kartu Profil Terintegrasi</span>
                <h3 class="font-bold text-sm text-white">{{ $user->name }}</h3>
            </div>
            <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/40 text-[10px] font-bold">
                Menunggu Verifikasi
            </span>
        </div>

        <div class="grid grid-cols-2 gap-2 text-xs py-3">
            <div>
                <span class="text-[10px] text-emerald-300 block">NIS Santri</span>
                <span class="font-mono font-bold text-white">{{ $user->alumniProfile->nis }}</span>
            </div>
            <div>
                <span class="text-[10px] text-emerald-300 block">Angkatan</span>
                <span class="font-semibold text-white">{{ $user->alumniProfile->angkatan ?? '-' }}</span>
            </div>
            <div>
                <span class="text-[10px] text-emerald-300 block">Jenjang Pondok</span>
                <span class="font-semibold text-white">{{ $user->alumniProfile->jenjang_pondok ?? '-' }}</span>
            </div>
            <div>
                <span class="text-[10px] text-emerald-300 block">Nomor WhatsApp</span>
                <span class="font-mono font-semibold text-white">{{ $user->no_wa }}</span>
            </div>
        </div>

        <div class="pt-2 border-t border-emerald-700/60 flex items-center justify-between text-[11px]">
            <span class="text-emerald-200">Status Akun:</span>
            <span class="text-amber-300 font-bold flex items-center space-x-1">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                <span>Menunggu Verifikasi Koordinator</span>
            </span>
        </div>
    </div>

    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-left text-xs text-amber-900 space-y-1">
        <div class="font-bold flex items-center space-x-1.5 text-amber-800">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>Langkah Berikutnya</span>
        </div>
        <p class="text-[11px] leading-relaxed">
            Pengurus/Koordinator Angkatan IKLIMB akan memeriksa validitas pendaftaran Anda. Setelah disetujui, Anda akan menerima pesan WhatsApp berisi tautan untuk membuat kata sandi dan mengaktifkan akun.
        </p>
    </div>

    <!-- Quick simulation helper for tester -->
    <div class="p-3 bg-slate-100 rounded-xl text-xs text-slate-600 text-left space-y-2 border border-slate-200">
        <div class="flex items-center justify-between">
            <span class="font-bold text-slate-800 flex items-center space-x-1.5">
                <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Panel Pengujian Cepat</span>
            </span>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-200 font-mono">Demo Mode</span>
        </div>
        <p class="text-[11px]">Anda dapat langsung masuk sebagai Koordinator IKLIMB untuk menyetujui akun ini:</p>
        <a href="{{ route('login.quick', 'koordinator') }}" class="block w-full py-2.5 px-3 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-center text-xs shadow-sm border border-emerald-600/80 transition active:scale-95">
            Masuk sebagai Koordinator &rarr; Verifikasi Akun Ini
        </a>
    </div>

    <div>
        <a href="{{ route('login') }}" class="inline-block text-xs font-semibold text-slate-600 hover:text-emerald-700">
            &larr; Kembali ke Halaman Masuk
        </a>
    </div>
</div>
@endsection
