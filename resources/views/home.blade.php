@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- 1. Top Section: Account Summary & Quick Visit Banner (Responsive Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 scroll-reveal">
        
        <!-- Account Summary Card (Spans 2 columns on desktop) -->
        <div class="{{ $kunjunganMendatang ? 'lg:col-span-2' : 'lg:col-span-3' }} bg-gradient-to-br from-emerald-950 via-emerald-800 to-emerald-950 text-white rounded-3xl p-5 lg:p-6 shadow-xl relative overflow-hidden border border-gold-400/30 flex flex-col justify-between">
            <!-- Background Ornament -->
            <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-gold-400/10 blur-xl pointer-events-none"></div>
            <div class="absolute -right-4 -bottom-4 opacity-15 pointer-events-none select-none">
                <img src="/images/logo-ppib.png" alt="Logo PPIB" class="w-36 h-36 object-contain">
            </div>

            <div class="flex items-start justify-between relative z-10">
                <div class="flex items-center space-x-3.5">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-2xl bg-gradient-to-tr from-gold-500 to-amber-300 text-slate-900 flex items-center justify-center font-black text-lg lg:text-xl shadow-md border-2 border-white/60">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <span class="text-[10px] lg:text-xs uppercase font-bold tracking-wider text-gold-300 block">
                            {{ $user->role_label }}
                        </span>
                        <h2 class="font-bold text-base lg:text-lg text-white tracking-tight">{{ $user->name }}</h2>
                        <p class="text-xs text-emerald-200">
                            @if($user->role === 'keamanan')
                                <span class="font-medium text-emerald-300">Petugas Keamanan</span> &bull; <span>Pos Jaga Gerbang & Verifikasi Tiket Kunjungan</span>
                            @elseif($user->role === 'admin')
                                <span class="font-medium text-gold-300">Super Administrator</span> &bull; <span>Pengelola Sistem Terpadu & Panel Kontrol PPIB</span>
                            @elseif($user->role === 'koordinator')
                                <span class="font-medium text-gold-300">Pengurus Koordinator</span> &bull; <span>Tim Verifikasi & Koordinasi Angkatan IKLIMB</span>
                            @else
                                NIS: <span class="font-mono font-semibold text-white">{{ $profile->nis ?? '-' }}</span> &bull; 
                                <span>{{ $profile->angkatan ?? 'Alumni' }}</span> &bull;
                                <span class="text-emerald-300">{{ $profile->jenjang_pondok ?? 'PPIB' }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm inline-flex items-center space-x-1.5 {{ $user->status === 'aktif' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/40' : 'bg-amber-500/20 text-amber-300 border border-amber-400/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $user->status === 'aktif' ? 'bg-emerald-400' : 'bg-amber-400' }}"></span>
                    <span>{{ $user->status_badge_label }}</span>
                </span>
            </div>

            <!-- Quick Action CTA Based on User Role -->
            <div class="mt-4 pt-4 border-t border-emerald-700/60 flex items-center justify-between flex-wrap gap-2 relative z-10">
                @if($user->role === 'keamanan')
                    <div class="text-xs text-emerald-200">
                        <span class="text-[11px] block text-emerald-300 font-medium">Tugas Pos Keamanan:</span>
                        <span class="text-xs text-white font-bold">Siaga Pemindaian QR Tamu & Alumni</span>
                    </div>
                    <a href="{{ route('keamanan.scanner') }}" class="py-2 px-3.5 bg-gradient-to-r from-teal-400 to-emerald-400 hover:from-teal-500 hover:to-emerald-500 text-slate-950 rounded-xl text-xs font-black shadow-md flex items-center space-x-1.5 transition transform active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Buka Scanner Kamera Gerbang &rarr;</span>
                    </a>
                @elseif($user->role === 'admin')
                    <div class="text-xs text-emerald-200">
                        <span class="text-[11px] block text-emerald-300 font-medium">Panel Kontrol Pengurus:</span>
                        <span class="text-xs text-gold-300 font-bold">Kabar, Donasi, Dokumen & Kunjungan</span>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="py-2 px-3.5 bg-gradient-to-r from-gold-400 to-amber-400 hover:from-gold-500 hover:to-amber-500 text-slate-950 rounded-xl text-xs font-black shadow-md flex items-center space-x-1.5 transition transform active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Buka Panel Admin &rarr;</span>
                    </a>
                @elseif($user->role === 'koordinator')
                    <div class="text-xs text-emerald-200">
                        <span class="text-[11px] block text-emerald-300 font-medium">Identitas Resmi Koordinator:</span>
                        <span class="font-mono text-xs text-gold-300 font-bold">{{ $profile->qr_identity_token ?? 'IKLIMB-KOORDINATOR' }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('koordinator.verifikasi') }}" class="py-2 px-3.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-md flex items-center space-x-1.5 border border-emerald-500/60 transition transform active:scale-95" title="Verifikasi Pendaftaran Calon Alumni">
                            <svg class="w-3.5 h-3.5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Verifikasi Alumni</span>
                        </a>
                        <a href="{{ route('kartu-alumni') }}" class="py-2 px-3.5 bg-gradient-to-r from-gold-400 to-amber-400 hover:from-gold-500 hover:to-amber-500 text-slate-950 rounded-xl text-xs font-bold shadow-md flex items-center space-x-1.5 transition transform active:scale-95" title="Buka Kartu QR Koordinator">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            <span>Kartu QR</span>
                        </a>
                    </div>
                @else
                    <div class="text-xs text-emerald-200">
                        <span class="text-[11px] block text-emerald-300">Identitas Resmi Alumni:</span>
                        <span class="font-mono text-xs text-gold-300 font-bold">{{ $profile->qr_identity_token ?? 'IKLIMB-ID' }}</span>
                    </div>
                    <a href="{{ route('kartu-alumni') }}" class="py-2 px-3.5 bg-gradient-to-r from-gold-400 to-amber-400 hover:from-gold-500 hover:to-amber-500 text-slate-950 rounded-xl text-xs font-bold shadow-md flex items-center space-x-1.5 transition transform active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        <span>Buka Kartu QR</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Active Visit Alert Card (Right Column on desktop) -->
        @if($kunjunganMendatang)
            <div class="lg:col-span-1 bg-amber-50 border border-amber-300 rounded-3xl p-5 shadow-sm flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-900 flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Jadwal Kunjungan Aktif</span>
                        </span>
                        <span class="px-2 py-0.5 rounded-full bg-amber-200 text-[10px] font-bold text-amber-800 uppercase">{{ $kunjunganMendatang->status }}</span>
                    </div>

                    <div>
                        <h4 class="font-bold text-sm text-amber-950">{{ $kunjunganMendatang->tujuan }}</h4>
                        <p class="text-xs text-amber-800 mt-0.5">Menemui: <strong>{{ $kunjunganMendatang->pihak_ditemui }}</strong></p>
                    </div>

                    <div class="p-2 bg-white/80 rounded-xl text-xs text-amber-900">
                        {{ $kunjunganMendatang->tanggal_kunjungan->format('d M Y') }} &bull; {{ substr($kunjunganMendatang->jam_kunjungan, 0, 5) }} WIB
                    </div>
                </div>

                <a href="{{ route('kunjungan.show', $kunjunganMendatang->id) }}" class="mt-3 w-full py-2 px-3 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold text-center shadow-sm">
                    Buka Tiket QR Gerbang &rarr;
                </a>
            </div>
        @endif

    </div>

    <!-- Smooth Scroll Down Indicator Hint -->
    <div class="flex justify-center -my-1">
        <a href="#semua-layanan" class="group inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-full bg-emerald-800/10 hover:bg-emerald-800/20 text-emerald-800 text-[11px] font-bold transition-all duration-300 shadow-xs active:scale-95 cursor-pointer">
            <span>Jelajahi 15 Modul Layanan</span>
            <svg class="w-3.5 h-3.5 text-emerald-700 animate-bounce-subtle group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </a>
    </div>

    <!-- 2. Kabar Pondok Terkini (Carousel on mobile, Responsive Grid on desktop) -->
    <div class="space-y-3 scroll-reveal">
        <div class="flex items-center justify-between">
            <h3 class="text-xs lg:text-sm font-bold uppercase tracking-wider text-slate-700 flex items-center space-x-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                <span>Kabar Pondok PPIB</span>
            </h3>
            <a href="{{ route('kabar-pondok.index') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">
                Lihat Semua &rarr;
            </a>
        </div>

        <!-- Responsive Container: Mobile horizontal scroll, Desktop 4-column Grid -->
        <div class="flex md:grid md:grid-cols-2 lg:grid-cols-4 gap-3.5 overflow-x-auto md:overflow-visible pb-2 md:pb-0 -mx-4 md:mx-0 px-4 md:px-0 scrollbar-none">
            @forelse($kabarTerbaru as $kabar)
                <a href="{{ route('kabar-pondok.show', $kabar->slug) }}" class="flex-shrink-0 w-64 md:w-auto bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md hover:border-emerald-500 transition flex flex-col justify-between">
                    <div>
                        <div class="h-28 bg-slate-100 relative">
                            <img src="{{ $kabar->gambar ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=500&q=80' }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover">
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-800/90 text-gold-300">
                                {{ $kabar->kategori }}
                            </span>
                        </div>
                        <div class="p-3">
                            <h4 class="font-bold text-xs text-slate-800 line-clamp-1 hover:text-emerald-700">{{ $kabar->judul }}</h4>
                            <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $kabar->ringkasan }}</p>
                        </div>
                    </div>
                    <div class="px-3 pb-3 pt-0">
                        <span class="text-[10px] text-slate-400 block">{{ $kabar->published_at ? $kabar->published_at->format('d M Y') : 'Baru' }}</span>
                    </div>
                </a>
            @empty
                <div class="col-span-4 w-full bg-white p-4 rounded-xl border border-slate-200 text-center text-xs text-slate-500">
                    Belum ada kabar pondok terbaru.
                </div>
            @endforelse
        </div>
    </div>

    <!-- 3. Semua Layanan (Responsive 2-Column Dashboard on Desktop) -->
    <div id="semua-layanan" class="space-y-4 pt-2 scroll-reveal">
        
        <div class="flex items-center justify-between border-b pb-2 border-slate-200">
            <div>
                <h3 class="text-sm lg:text-base font-extrabold text-slate-900 tracking-tight">Semua Layanan IKLIMB</h3>
                <p class="text-xs text-slate-500 hidden sm:block">Akses 15 modul layanan terpadu alumni Pondok Pesantren PPIB</p>
            </div>
            <span class="text-[11px] text-emerald-800 font-bold px-2.5 py-1 bg-emerald-50 border border-emerald-200 rounded-full">
                15 Layanan Aktif
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
            
            <!-- Left Column: Kelompok A (Inti) & B (Administrasi) -->
            <div class="space-y-4">
                
                <!-- A. Kelompok Menu Inti -->
                <div class="bg-white p-4 lg:p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-800 flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            <span>A. Kelompok Menu Inti</span>
                        </span>
                        <span class="text-[10px] px-1.5 py-0.5 bg-emerald-100 text-emerald-800 font-bold rounded">Tahap 1 MVP</span>
                    </div>
                    
                    <div class="mobile-icon-grid-4 text-center">
                        <!-- 1. Menu Utama Berdasarkan Role Pengguna -->
                        @if(auth()->user()->role === 'keamanan')
                            <a href="{{ route('keamanan.scanner') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]" title="Buka Kamera Scanner Pos Gerbang">
                                <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                    <svg class="w-5 h-5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Scanner Pos</span>
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]" title="Buka Panel Kontrol Admin">
                                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Panel Admin</span>
                            </a>
                        @else
                            <a href="{{ route('kartu-alumni') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]" title="Buka Kartu Alumni Digital QR">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                    <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Kartu QR</span>
                            </a>
                        @endif

                        <!-- 2. Kunjungan ke Pondok -->
                        <a href="{{ route('kunjungan.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Kunjungan</span>
                        </a>

                        <!-- 3. Kabar Pondok -->
                        <a href="{{ route('kabar-pondok.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Kabar Pondok</span>
                        </a>

                        <!-- 4. Direktori Alumni -->
                        <a href="{{ route('direktori-alumni.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Direktori</span>
                        </a>
                    </div>
                </div>

                <!-- B. Kelompok Layanan Administrasi -->
                <div class="bg-white p-4 lg:p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-600 flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <span>B. Layanan Administrasi</span>
                        </span>
                        <span class="text-[10px] text-slate-400">Tata Usaha</span>
                    </div>
                    
                    <div class="mobile-icon-grid-3 text-center">
                        <!-- 5. Permohonan Dokumen -->
                        <a href="{{ route('permohonan-dokumen.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group relative bg-slate-50/60 active:scale-95 min-h-[82px]">
                            @if($permohonanAktifCount > 0)
                                <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-emerald-600 text-[9px] font-bold text-white rounded-full flex items-center justify-center">{{ $permohonanAktifCount }}</span>
                            @endif
                            <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Dokumen TU</span>
                            <span class="text-[9px] text-emerald-600 font-semibold mt-0.5">Legalisir & Surat</span>
                        </a>

                        <!-- 6. Tracer Study -->
                        <a href="{{ route('tracer-study.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-cyan-100 text-cyan-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Tracer Study</span>
                            <span class="text-[9px] text-slate-400 mt-0.5">Kiprah Alumni</span>
                        </a>

                        <!-- 7. PSB Jalur Alumni -->
                        <a href="{{ route('psb-alumni.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">PSB Alumni</span>
                            <span class="text-[9px] text-slate-400 mt-0.5">Daftar Santri</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Right Column: Kelompok C (Jejaring) & D (Kontribusi) -->
            <div class="space-y-4">
                
                <!-- C. Kelompok Jejaring & Pemberdayaan -->
                <div class="bg-white p-4 lg:p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-600 flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <span>C. Jejaring & Pemberdayaan</span>
                        </span>
                        <span class="text-[10px] text-slate-400">Ukhuwah</span>
                    </div>
                    
                    <div class="mobile-icon-grid-4 text-center">
                        <!-- 8. Agenda & Reuni -->
                        <a href="{{ route('agenda-reuni.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Agenda</span>
                        </a>

                        <!-- 9. Info Lowongan & Usaha -->
                        <a href="{{ route('info-lowongan-usaha.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-orange-100 text-orange-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Lowongan</span>
                        </a>

                        <!-- 10. Peta Sebaran Alumni -->
                        <a href="{{ route('peta-alumni.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Peta Sebaran</span>
                        </a>

                        <!-- 11. Forum Angkatan -->
                        <a href="{{ route('forum-angkatan.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-green-100 text-green-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Forum WA</span>
                        </a>
                    </div>
                </div>

                <!-- D. Kelompok Kontribusi & Keilmuan -->
                <div class="bg-white p-4 lg:p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-600 flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <span>D. Kontribusi & Keilmuan</span>
                        </span>
                        <span class="text-[10px] text-slate-400">Dakwah</span>
                    </div>
                    
                    <div class="mobile-icon-grid-4 text-center">
                        <!-- 12. Donasi & Wakaf -->
                        <a href="{{ route('donasi-wakaf.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Donasi</span>
                        </a>

                        <!-- 13. Kajian & Materi -->
                        <a href="{{ route('kajian-materi.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Kajian</span>
                        </a>

                        <!-- 14. Tanya Ustaz -->
                        <a href="{{ route('tanya-ustaz.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Tanya Ustaz</span>
                        </a>

                        <!-- 15. Saran & Masukan -->
                        <a href="{{ route('saran-masukan.index') }}" class="p-2 sm:p-2.5 rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition flex flex-col items-center justify-center group bg-slate-50/60 active:scale-95 min-h-[82px]">
                            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-800 flex items-center justify-center group-hover:scale-105 transition shadow-inner">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            </div>
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-700 mt-1.5 group-hover:text-emerald-700 leading-tight">Aspirasi</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
