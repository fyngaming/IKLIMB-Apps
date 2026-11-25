@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Admin Header Banner -->
    <div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-emerald-950 text-white p-6 rounded-3xl shadow-xl border border-gold-400/30 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-gold-400 text-slate-950 text-[10px] font-black uppercase tracking-wider">
                        Pusat Kontrol Sistem
                    </span>
                    <span class="text-xs text-emerald-300 font-semibold">&bull; {{ auth()->user()->name }}</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-white mt-1">Dashboard Panel Admin IKLIMB</h1>
                <p class="text-xs text-emerald-200 mt-1 max-w-2xl leading-relaxed">
                    Kelola seluruh aspek ekosistem alumni PPIB: publikasi kabar pondok, program donasi & wakaf, penerbitan dokumen TU, arsip kajian asatizah, hingga fatwa konsultasi keagamaan.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.donasi.index') }}" class="px-3.5 py-2 rounded-xl bg-gold-400 hover:bg-gold-500 text-slate-950 font-extrabold text-xs shadow-md transition flex items-center space-x-1.5">
                    <span>+ Buka Donasi Baru</span>
                </a>
                <a href="{{ route('admin.kabar.index') }}" class="px-3.5 py-2 rounded-xl bg-emerald-700/80 hover:bg-emerald-600 text-white font-bold text-xs border border-emerald-600 shadow transition flex items-center space-x-1.5">
                    <span>+ Tulis Kabar</span>
                </a>
            </div>
        </div>
        <!-- Watermark ornament -->
        <div class="absolute -right-8 -bottom-8 w-44 h-44 opacity-10 pointer-events-none">
            <img src="/images/logo-ppib.png" alt="Emblem" class="w-full h-full object-contain">
        </div>
    </div>

    <!-- Admin Navigation Tabs -->
    <div class="flex items-center space-x-2 overflow-x-auto pb-1 text-xs font-bold border-b border-slate-200">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl transition bg-emerald-800 text-white shadow-sm flex items-center space-x-1.5 flex-shrink-0">
            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span>Ringkasan</span>
        </a>
        <a href="{{ route('admin.donasi.index') }}" class="px-4 py-2.5 rounded-xl transition hover:bg-slate-100 text-slate-700 flex items-center space-x-1.5 flex-shrink-0">
            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            <span>Donasi & Wakaf</span>
            @if($stats['donasi_aktif'] > 0)
                <span class="px-1.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px]">{{ $stats['donasi_aktif'] }}</span>
            @endif
        </a>
        <a href="{{ route('admin.kabar.index') }}" class="px-4 py-2.5 rounded-xl transition hover:bg-slate-100 text-slate-700 flex items-center space-x-1.5 flex-shrink-0">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            <span>Kabar Pondok</span>
            <span class="px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px]">{{ $stats['kabar_count'] }}</span>
        </a>
        <a href="{{ route('admin.dokumen.index') }}" class="px-4 py-2.5 rounded-xl transition hover:bg-slate-100 text-slate-700 flex items-center space-x-1.5 flex-shrink-0">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Dokumen TU</span>
            @if($stats['dokumen_pending'] > 0)
                <span class="px-1.5 py-0.5 rounded-full bg-amber-500 text-white text-[10px]">{{ $stats['dokumen_pending'] }}</span>
            @endif
        </a>
        <a href="{{ route('admin.kajian.index') }}" class="px-4 py-2.5 rounded-xl transition hover:bg-slate-100 text-slate-700 flex items-center space-x-1.5 flex-shrink-0">
            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span>Kajian & Daurah</span>
            <span class="px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px]">{{ $stats['kajian_count'] }}</span>
        </a>
        <a href="{{ route('admin.tanya-ustaz.index') }}" class="px-4 py-2.5 rounded-xl transition hover:bg-slate-100 text-slate-700 flex items-center space-x-1.5 flex-shrink-0">
            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            <span>Tanya Ustaz</span>
            @if($stats['tanya_ustaz_pending'] > 0)
                <span class="px-1.5 py-0.5 rounded-full bg-rose-500 text-white text-[10px]">{{ $stats['tanya_ustaz_pending'] }}</span>
            @endif
        </a>
        <a href="{{ route('koordinator.verifikasi') }}" class="px-4 py-2.5 rounded-xl transition hover:bg-slate-100 text-slate-700 flex items-center space-x-1.5 flex-shrink-0">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            <span>Verifikasi Alumni</span>
            @if($stats['alumni_pending'] > 0)
                <span class="px-1.5 py-0.5 rounded-full bg-amber-500 text-white text-[10px]">{{ $stats['alumni_pending'] }}</span>
            @endif
        </a>
        <a href="{{ route('kunjungan.index') }}" class="px-4 py-2.5 rounded-xl transition hover:bg-slate-100 text-slate-700 flex items-center space-x-1.5 flex-shrink-0">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span>Kunjungan Sowan</span>
            @if($stats['kunjungan_pending'] > 0)
                <span class="px-1.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px]">{{ $stats['kunjungan_pending'] }}</span>
            @endif
        </a>
    </div>

    <!-- Metrics Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 responsive-grid-2">
        <!-- Card 1 -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Alumni Terdaftar</span>
            <p class="text-xl sm:text-2xl font-black text-slate-900">{{ number_format($stats['total_alumni']) }}</p>
            <div class="text-[10px] text-emerald-600 font-semibold flex items-center space-x-1">
                <span>{{ $stats['alumni_aktif'] }} Akun Aktif</span>
            </div>
        </div>

        <!-- Card 2 -->
        <a href="{{ route('admin.donasi.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-1 hover:border-emerald-500 transition group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Donasi Terkumpul</span>
            <p class="text-lg sm:text-xl font-black text-emerald-700 truncate">Rp {{ number_format($stats['dana_terkumpul'] / 1000000, 1) }} Jt</p>
            <div class="text-[10px] text-slate-500 font-semibold flex items-center space-x-1">
                <span class="text-emerald-700 font-bold group-hover:underline">{{ $stats['donasi_aktif'] }} Program Aktif &rarr;</span>
            </div>
        </a>

        <!-- Card 3 -->
        <a href="{{ route('admin.dokumen.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-1 hover:border-amber-500 transition group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Dokumen TU</span>
            <p class="text-xl sm:text-2xl font-black text-amber-600">{{ $stats['dokumen_pending'] }}</p>
            <div class="text-[10px] text-slate-500 font-semibold flex items-center space-x-1">
                <span class="group-hover:underline">Perlu Diproses &rarr;</span>
            </div>
        </a>

        <!-- Card 4 -->
        <a href="{{ route('kunjungan.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-1 hover:border-emerald-500 transition group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kunjungan Tamu</span>
            <p class="text-xl sm:text-2xl font-black text-slate-800">{{ $stats['kunjungan_pending'] }}</p>
            <div class="text-[10px] text-slate-500 font-semibold flex items-center space-x-1">
                <span class="group-hover:underline">Menunggu Izin &rarr;</span>
            </div>
        </a>

        <!-- Card 5 -->
        <a href="{{ route('admin.tanya-ustaz.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-1 hover:border-rose-500 transition group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanya Ustaz</span>
            <p class="text-xl sm:text-2xl font-black text-rose-600">{{ $stats['tanya_ustaz_pending'] }}</p>
            <div class="text-[10px] text-slate-500 font-semibold flex items-center space-x-1">
                <span class="group-hover:underline">Belum Dijawab &rarr;</span>
            </div>
        </a>

        <!-- Card 6 -->
        <a href="{{ route('admin.kabar.index') }}" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-1 hover:border-emerald-500 transition group">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kabar Pondok</span>
            <p class="text-xl sm:text-2xl font-black text-slate-800">{{ $stats['kabar_count'] }}</p>
            <div class="text-[10px] text-slate-500 font-semibold flex items-center space-x-1">
                <span class="group-hover:underline">Artikel Terbit &rarr;</span>
            </div>
        </a>
    </div>

    <!-- Quick Management Shortcut Panels -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 responsive-grid-2">
        <a href="{{ route('admin.donasi.index') }}" class="p-5 bg-white rounded-3xl border border-slate-200 hover:border-gold-400 shadow-sm hover:shadow-md transition space-y-3 group">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition shadow-inner">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <div>
                <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-emerald-800 transition">Buka & Kelola Donasi</h3>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Tambah program wakaf baru, tentukan target dana, dan pantau transfer para donatur alumni.</p>
            </div>
            <span class="inline-block text-xs font-bold text-gold-600 group-hover:underline">Kelola Donasi &rarr;</span>
        </a>

        <a href="{{ route('admin.kabar.index') }}" class="p-5 bg-white rounded-3xl border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-md transition space-y-3 group">
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition shadow-inner">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </div>
            <div>
                <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-emerald-800 transition">Publikasi Kabar Pondok</h3>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Terbitkan berita terkini, pengumuman resmi, rilis agenda, dan artikel inspiratif alumni.</p>
            </div>
            <span class="inline-block text-xs font-bold text-emerald-700 group-hover:underline">Kelola Kabar &rarr;</span>
        </a>

        <a href="{{ route('admin.dokumen.index') }}" class="p-5 bg-white rounded-3xl border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-md transition space-y-3 group">
            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition shadow-inner">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-emerald-800 transition">Layanan Dokumen TU</h3>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Proses legalisasi ijazah, surat keterangan, dan surat rekomendasi studi alumni.</p>
            </div>
            <span class="inline-block text-xs font-bold text-blue-700 group-hover:underline">Proses Dokumen &rarr;</span>
        </a>

        <a href="{{ route('admin.kajian.index') }}" class="p-5 bg-white rounded-3xl border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-md transition space-y-3 group">
            <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition shadow-inner">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-emerald-800 transition">Kajian & Keilmuan</h3>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Unggah materi daurah, embed video kajian YouTube, dan artikel kitab para asatizah.</p>
            </div>
            <span class="inline-block text-xs font-bold text-purple-700 group-hover:underline">Kelola Kajian &rarr;</span>
        </a>
    </div>

    <!-- Recent Activities & Tasks Split Table -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 responsive-grid-2">
        <!-- Permohonan Dokumen Menunggu -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b pb-3">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h2 class="font-extrabold text-sm text-slate-900">Permohonan Dokumen Terbaru</h2>
                </div>
                <a href="{{ route('admin.dokumen.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">Semua Dokumen &rarr;</a>
            </div>

            @if($recentDokumen->isEmpty())
                <p class="text-xs text-slate-400 py-4 text-center">Belum ada antrean permohonan dokumen.</p>
            @else
                <div class="space-y-2.5">
                    @foreach($recentDokumen as $dok)
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between text-xs">
                            <div class="space-y-0.5">
                                <span class="font-bold text-slate-900 block">{{ $dok->jenis_dokumen }}</span>
                                <p class="text-[11px] text-slate-500">Pemohon: <span class="font-semibold text-slate-700">{{ $dok->user->name }}</span> &bull; No: #{{ $dok->nomor_permohonan }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $dok->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $dok->status }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Tanya Ustaz Menunggu Jawaban -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b pb-3">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <h2 class="font-extrabold text-sm text-slate-900">Konsultasi Keagamaan Menunggu Jawaban</h2>
                </div>
                <a href="{{ route('admin.tanya-ustaz.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">Beri Jawaban &rarr;</a>
            </div>

            @if($recentTanyaUstaz->isEmpty())
                <p class="text-xs text-slate-400 py-4 text-center">Tidak ada pertanyaan yang menunggu jawaban saat ini.</p>
            @else
                <div class="space-y-2.5">
                    @foreach($recentTanyaUstaz as $tanya)
                        <div class="p-3 rounded-2xl bg-rose-50/50 border border-rose-100 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 font-bold text-[10px]">{{ $tanya->kategori_keilmuan }}</span>
                                <span class="text-[10px] text-slate-400">{{ $tanya->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="font-bold text-slate-900">{{ $tanya->judul_pertanyaan }}</h4>
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">{{ $tanya->pertanyaan }}</p>
                            <div class="pt-1 flex items-center justify-between">
                                <span class="text-[10px] text-slate-500">Penanya: {{ $tanya->is_anonim ? 'Hamba Allah (Anonim)' : $tanya->penanya->name }}</span>
                                <a href="{{ route('admin.tanya-ustaz.index') }}" class="text-[11px] font-bold text-emerald-700 hover:underline">Tulis Jawaban &rarr;</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
