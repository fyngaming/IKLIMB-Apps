<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#065f46">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="IKLIMB Apps">
    
    <title>{{ $title ?? 'IKLIMB Apps' }} - Alumni Ponpes PPIB</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" sizes="64x64" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN with Container Queries Plugin -->
    <script src="https://cdn.tailwindcss.com?plugins=container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        gold: {
                            50: '#fefce8',
                            100: '#fef9c3',
                            200: '#fef08a',
                            300: '#fde047',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        arabic: ['"Amiri"', 'serif']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            -webkit-tap-highlight-color: transparent;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Enforce single-column mobile view inside mobile mode even on desktop monitors */
        [data-view-mode="mobile"] .grid-cols-1.lg\:grid-cols-2,
        [data-view-mode="mobile"] .grid-cols-1.lg\:grid-cols-3,
        [data-view-mode="mobile"] .grid-cols-1.lg\:grid-cols-4,
        [data-view-mode="mobile"] .lg\:grid-cols-2,
        [data-view-mode="mobile"] .lg\:grid-cols-3,
        [data-view-mode="mobile"] .lg\:grid-cols-4,
        [data-view-mode="mobile"] .md\:grid-cols-2,
        [data-view-mode="mobile"] .md\:grid-cols-3,
        [data-view-mode="mobile"] .md\:grid-cols-4,
        [data-view-mode="mobile"] .sm\:grid-cols-2,
        [data-view-mode="mobile"] .sm\:grid-cols-3,
        [data-view-mode="mobile"] .responsive-grid-2,
        [data-view-mode="mobile"] .responsive-grid-3,
        [data-view-mode="mobile"] .responsive-grid-4 {
            grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        }

        [data-view-mode="mobile"] [class*="lg:col-span-"],
        [data-view-mode="mobile"] [class*="md:col-span-"],
        [data-view-mode="mobile"] [class*="sm:col-span-"],
        [data-view-mode="mobile"] .responsive-col-span-2,
        [data-view-mode="mobile"] .responsive-col-span-3,
        [data-view-mode="mobile"] .responsive-col-span-4,
        [data-view-mode="mobile"] .responsive-col-span-5,
        [data-view-mode="mobile"] .responsive-col-span-6,
        [data-view-mode="mobile"] .responsive-col-span-7,
        [data-view-mode="mobile"] .responsive-col-span-8 {
            grid-column: span 1 / span 1 !important;
        }

        [data-view-mode="mobile"] .hidden.lg\:flex,
        [data-view-mode="mobile"] .hidden.lg\:block,
        [data-view-mode="mobile"] .hidden.md\:flex,
        [data-view-mode="mobile"] .hidden.md\:block,
        [data-view-mode="mobile"] .hidden.sm\:block,
        [data-view-mode="mobile"] .responsive-desktop-only {
            display: none !important;
        }

        [data-view-mode="mobile"] .lg\:hidden,
        [data-view-mode="mobile"] .md\:hidden {
            display: block !important;
        }

        /* Horizontal swipe container on mobile */
        [data-view-mode="mobile"] .flex.md\:grid {
            display: flex !important;
            flex-direction: row !important;
            overflow-x: auto !important;
            padding-bottom: 0.5rem !important;
        }
        [data-view-mode="mobile"] .flex.md\:grid > * {
            flex-shrink: 0 !important;
            width: 16rem !important;
        }

        /* Internal shortcut icon grids remain multi-column on mobile */
        .mobile-icon-grid-4,
        [data-view-mode="mobile"] .mobile-icon-grid-4 {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 0.5rem !important;
        }
        .mobile-icon-grid-3,
        [data-view-mode="mobile"] .mobile-icon-grid-3 {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 0.5rem !important;
        }

        /* Smooth Scroll & Scroll Down Reveal Animations */
        html {
            scroll-behavior: smooth;
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.55s cubic-bezier(0.16, 1, 0.3, 1), transform 0.55s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .scroll-reveal.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes subtleBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(4px); }
        }

        .animate-bounce-subtle {
            animation: subtleBounce 2.2s ease-in-out infinite;
        }
    </style>
    @stack('styles')
</head>
<body x-data="responsiveLayout()" x-init="initLayout()"
      :class="bodyClass"
      :data-view-mode="mode"
      :data-is-mobile="isMobileView ? 'true' : 'false'"
      class="text-slate-800 antialiased min-h-screen">

    <!-- Main Container Wrapper (Frameless Mobile Layout on Mobile Mode, Full-Screen on Desktop) -->
    <div :class="containerClass" class="@container transition-all duration-300">

        <!-- Top Header & Navigation (Full-width across desktop screen) -->
        <header class="sticky top-0 z-40 bg-gradient-to-r from-emerald-950 via-emerald-800 to-emerald-950 text-white shadow-md border-b border-gold-400/20 backdrop-blur-md">
            <div :class="isMobileView ? 'px-4 py-3' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5'" class="w-full flex items-center justify-between">
                
                <!-- Brand & Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-2xl bg-white/95 p-1 border border-gold-400/80 flex items-center justify-center shadow-md group-hover:scale-105 transition">
                            <img src="/images/logo-ppib.png" alt="Logo PPIB" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="font-black text-lg tracking-wide text-white">IKLIMB</span>
                                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-gold-400 text-slate-950 uppercase tracking-widest shadow-sm">Apps</span>
                            </div>
                            <p class="text-[11px] text-emerald-200 font-medium hidden sm:block">
                                {{ auth()->check() && auth()->user()->role === 'admin' ? 'Panel Administrator Sistem & Kontrol PPIB' : 'Ikatan Keluarga Alumni Ponpes PPIB' }}
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Menu (Visible on Desktop View for Alumni & Non-Admin Roles) -->
                @if(!auth()->check() || auth()->user()->role !== 'admin')
                    <nav x-show="!isMobileView" class="hidden lg:flex items-center space-x-1.5 xl:space-x-2 text-xs font-semibold text-emerald-100">
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl transition flex items-center space-x-1.5 {{ request()->routeIs('home') ? 'bg-emerald-700 text-white font-bold shadow-sm' : 'hover:bg-emerald-800/80 hover:text-white' }}">
                            <span>Beranda</span>
                        </a>
                        <a href="{{ route('kunjungan.index') }}" class="px-3 py-2 rounded-xl transition flex items-center space-x-1.5 {{ request()->routeIs('kunjungan.*') ? 'bg-emerald-700 text-white font-bold shadow-sm' : 'hover:bg-emerald-800/80 hover:text-white' }}">
                            <span>Kunjungan</span>
                        </a>
                        <a href="{{ route('kabar-pondok.index') }}" class="px-3 py-2 rounded-xl transition flex items-center space-x-1.5 {{ request()->routeIs('kabar-pondok.*') ? 'bg-emerald-700 text-white font-bold shadow-sm' : 'hover:bg-emerald-800/80 hover:text-white' }}">
                            <span>Kabar Pondok</span>
                        </a>

                        <!-- Dropdown Layanan Alumni -->
                        <div class="relative" x-data="{ openLayanan: false }">
                            <button type="button" @click="openLayanan = !openLayanan" class="px-3 py-2 rounded-xl transition flex items-center space-x-1.5 {{ request()->routeIs('permohonan-dokumen.*', 'direktori-alumni.*', 'donasi-wakaf.*', 'peta-alumni.*', 'tracer-study.*', 'agenda-reuni.*', 'info-lowongan-usaha.*', 'psb-alumni.*', 'kajian-materi.*', 'forum-angkatan.*', 'tanya-ustaz.*', 'saran-masukan.*') ? 'bg-emerald-700 text-white font-bold shadow-sm' : 'hover:bg-emerald-800/80 hover:text-white' }}">
                                <span>Semua Layanan</span>
                                <svg class="w-3.5 h-3.5 transition transform text-emerald-300" :class="openLayanan ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="openLayanan" @click.away="openLayanan = false" x-cloak class="absolute left-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2.5 z-50 text-xs text-slate-800">
                                <div class="px-3.5 py-1 text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50/70 mx-2 rounded-lg mb-1.5">
                                    Layanan & Jejaring Alumni
                                </div>
                                <div class="grid grid-cols-2 gap-0.5 px-1.5">
                                    <a href="{{ route('permohonan-dokumen.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span class="font-semibold truncate">Dokumen TU</span>
                                    </a>
                                    <a href="{{ route('direktori-alumni.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span class="font-semibold truncate">Direktori</span>
                                    </a>
                                    <a href="{{ route('donasi-wakaf.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        <span class="font-semibold truncate">Donasi & Wakaf</span>
                                    </a>
                                    <a href="{{ route('peta-alumni.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="font-semibold truncate">Peta Sebaran</span>
                                    </a>
                                    <a href="{{ route('agenda-reuni.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="font-semibold truncate">Agenda Reuni</span>
                                    </a>
                                    <a href="{{ route('info-lowongan-usaha.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span class="font-semibold truncate">Karir & Usaha</span>
                                    </a>
                                    <a href="{{ route('tracer-study.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-cyan-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        <span class="font-semibold truncate">Tracer Study</span>
                                    </a>
                                    <a href="{{ route('psb-alumni.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                        <span class="font-semibold truncate">PSB Alumni</span>
                                    </a>
                                    <a href="{{ route('kajian-materi.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <span class="font-semibold truncate">Kajian & Daurah</span>
                                    </a>
                                    <a href="{{ route('tanya-ustaz.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="font-semibold truncate">Tanya Ustaz</span>
                                    </a>
                                    <a href="{{ route('forum-angkatan.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        <span class="font-semibold truncate">Forum Angkatan</span>
                                    </a>
                                    <a href="{{ route('saran-masukan.index') }}" class="flex items-center space-x-2 px-2.5 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-900 transition">
                                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                        <span class="font-semibold truncate">Saran Aspirasi</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>
                @endif

                <!-- Right Side Actions & User Profile -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    @auth
                        @if(auth()->user()->role !== 'admin')
                            <!-- Separator before actions on desktop -->
                            <div class="h-6 w-px bg-emerald-700/60 hidden lg:block mr-0.5"></div>
                        @endif

                        <!-- Panel Admin Button (Only for Admin, clearly separated) -->
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-xl transition flex items-center space-x-1.5 {{ request()->routeIs('admin.*') ? 'bg-gold-500 text-slate-950 font-black shadow-md' : 'bg-emerald-950/80 text-gold-300 border border-gold-400/60 hover:bg-emerald-800 hover:text-white' }} shadow-sm text-xs" title="Panel Kontrol Admin">
                                <svg class="w-3.5 h-3.5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="font-bold">Panel Admin</span>
                            </a>
                        @endif

                        <!-- Kartu QR Quick Pill (Hanya untuk Alumni & Koordinator) -->
                        @if(auth()->user()->role === 'alumni' || auth()->user()->role === 'koordinator')
                            <a href="{{ route('kartu-alumni') }}" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-gold-400 to-amber-400 hover:from-gold-500 hover:to-amber-500 text-slate-950 font-extrabold text-xs flex items-center space-x-1.5 shadow-md transition" title="Buka Kartu Alumni Digital QR">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                <span class="hidden sm:inline">Kartu QR</span>
                            </a>
                        @endif

                        @if(auth()->user()->role === 'keamanan')
                            <a href="{{ route('keamanan.scanner') }}" class="px-2.5 sm:px-3 py-1.5 rounded-xl bg-emerald-700/90 hover:bg-emerald-600 text-emerald-100 text-xs font-bold flex items-center space-x-1.5 border border-emerald-600/70 shadow-sm transition" title="Buka Scanner Pos Satpam">
                                <svg class="w-4 h-4 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="hidden md:inline">Scanner Pos</span>
                            </a>
                        @endif

                        @if(auth()->user()->role === 'koordinator' || auth()->user()->role === 'admin')
                            <a href="{{ route('koordinator.verifikasi') }}" class="relative p-2 rounded-xl bg-emerald-700/60 hover:bg-emerald-600 text-emerald-100 border border-emerald-600/50 transition" title="Verifikasi Pendaftaran Alumni">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                @php
                                    $pendingCount = \App\Models\User::where('role', 'alumni')->where('status', 'menunggu_verifikasi')->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-amber-500 text-[9px] font-bold text-white flex items-center justify-center">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        @endif

                        <!-- User Profile Pill & Quick Dropdown -->
                        <div class="relative" x-data="{ openProfile: false }">
                            <button type="button" @click="openProfile = !openProfile" class="flex items-center space-x-2 pl-2 pr-3 py-1 rounded-full bg-emerald-800/80 hover:bg-emerald-700/90 border border-gold-400/40 transition">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-gold-500 to-amber-300 text-slate-900 flex items-center justify-center text-xs font-black shadow-inner">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <div class="text-left hidden sm:block">
                                    <span class="text-xs font-bold text-white block max-w-[120px] truncate leading-tight">{{ auth()->user()->name }}</span>
                                    <span class="text-[9px] text-gold-300 font-semibold block">
                                        @if(auth()->user()->role === 'admin')
                                            Super Admin
                                        @elseif(auth()->user()->role === 'koordinator')
                                            Koordinator
                                        @elseif(auth()->user()->role === 'keamanan')
                                            Pos Keamanan
                                        @else
                                            Alumni PPIB
                                        @endif
                                    </span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-emerald-300 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="openProfile" @click.away="openProfile = false" x-cloak class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2 z-[60] text-xs text-slate-800">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-mono">{{ auth()->user()->no_wa }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ auth()->user()->role === 'admin' ? 'bg-amber-100 text-amber-900' : (auth()->user()->role === 'koordinator' ? 'bg-emerald-100 text-emerald-800' : (auth()->user()->role === 'keamanan' ? 'bg-teal-100 text-teal-900' : 'bg-slate-100 text-slate-800')) }}">
                                        @if(auth()->user()->role === 'admin')
                                            Super Administrator
                                        @elseif(auth()->user()->role === 'koordinator')
                                            Koordinator Angkatan
                                        @elseif(auth()->user()->role === 'keamanan')
                                            Petugas Pos Keamanan
                                        @else
                                            Alumni PPIB
                                        @endif
                                    </span>
                                </div>

                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-4 py-2.5 bg-gold-50 text-amber-900 font-bold hover:bg-gold-100 transition border-b border-slate-100">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>Panel Kontrol Admin</span>
                                    </a>
                                @endif

                                @if(auth()->user()->role === 'koordinator')
                                    <a href="{{ route('koordinator.verifikasi') }}" class="flex items-center space-x-2 px-4 py-2.5 bg-emerald-50 text-emerald-900 font-bold hover:bg-emerald-100 transition border-b border-slate-100">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        <span>Verifikasi Pendaftaran Alumni</span>
                                    </a>
                                @endif

                                <a href="{{ route('profil.index') }}" class="flex items-center space-x-2 px-4 py-2 hover:bg-emerald-50 hover:text-emerald-800 font-semibold transition">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span>Profil & Biodata</span>
                                </a>

                                <div class="border-t border-slate-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-rose-600 hover:bg-rose-50 font-semibold transition text-left">
                                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-1.5 rounded-xl bg-gold-500 hover:bg-gold-600 text-slate-950 text-xs font-bold shadow transition">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Body Content (Full-width with inner max-w-7xl) -->
        <main class="flex-1 w-full" :class="isMobileView ? 'pb-24 px-4 pt-3' : 'pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6'">
            
            <!-- Flash Notifications -->
            <div :class="isMobileView ? 'w-full mb-3' : 'w-full mb-4'">
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-300 rounded-2xl text-emerald-800 text-xs flex items-center space-x-2.5 shadow-sm" x-data="{ show: true }" x-show="show">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <div class="flex-1 font-semibold">{{ session('success') }}</div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-rose-50 border border-rose-300 rounded-2xl text-rose-800 text-xs flex items-center space-x-2.5 shadow-sm" x-data="{ show: true }" x-show="show">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="flex-1 font-semibold">{{ session('error') }}</div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700 font-bold">&times;</button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="p-4 bg-amber-50 border border-amber-300 rounded-2xl text-amber-900 text-xs flex items-center space-x-2.5 shadow-sm" x-data="{ show: true }" x-show="show">
                        <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="flex-1 font-semibold">{{ session('info') }}</div>
                        <button @click="show = false" class="text-amber-500 hover:text-amber-700 font-bold">&times;</button>
                    </div>
                @endif
            </div>

            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Bottom Navigation Bar (Shown on Mobile View & Screens < 1024px) -->
        <nav x-show="isMobileView"
            class="fixed bottom-0 left-0 right-0 w-full z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/80 px-1.5 py-1.5 shadow-[0_-4px_20px_rgba(0,0,0,0.08)]">
            <div class="max-w-md mx-auto grid grid-cols-5 gap-0.5 sm:gap-1 text-center">
                
                <!-- 1. Beranda -->
                <a href="{{ route('home') }}" class="group flex flex-col items-center justify-center py-1 rounded-xl transition-colors duration-200 {{ request()->routeIs('home') ? 'text-emerald-700 font-bold bg-emerald-50/70' : 'text-slate-500 hover:text-emerald-700 hover:bg-slate-50 font-medium' }}">
                    <div class="relative transition-colors duration-200 {{ request()->routeIs('home') ? 'text-emerald-700' : 'text-slate-500 group-hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 transition-colors duration-200" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        @if(request()->routeIs('home'))
                            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-emerald-600 rounded-full"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-1 tracking-tight truncate w-full text-center">Beranda</span>
                </a>

                <!-- 2. Kunjungan -->
                <a href="{{ route('kunjungan.index') }}" class="group flex flex-col items-center justify-center py-1 rounded-xl transition-colors duration-200 {{ request()->routeIs('kunjungan.*') ? 'text-emerald-700 font-bold bg-emerald-50/70' : 'text-slate-500 hover:text-emerald-700 hover:bg-slate-50 font-medium' }}">
                    <div class="relative transition-colors duration-200 {{ request()->routeIs('kunjungan.*') ? 'text-emerald-700' : 'text-slate-500 group-hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 transition-colors duration-200" fill="{{ request()->routeIs('kunjungan.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        @if(request()->routeIs('kunjungan.*'))
                            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-emerald-600 rounded-full"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-1 tracking-tight truncate w-full text-center">Kunjungan</span>
                </a>

                <!-- 3. Kabar Pondok (Tombol Baru di Posisi Tengah) -->
                <a href="{{ route('kabar-pondok.index') }}" class="group flex flex-col items-center justify-center py-1 rounded-xl transition-colors duration-200 {{ request()->routeIs('kabar-pondok.*') ? 'text-emerald-700 font-bold bg-emerald-50/70' : 'text-slate-500 hover:text-emerald-700 hover:bg-slate-50 font-medium' }}">
                    <div class="relative transition-colors duration-200 {{ request()->routeIs('kabar-pondok.*') ? 'text-emerald-700' : 'text-slate-500 group-hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 transition-colors duration-200" fill="{{ request()->routeIs('kabar-pondok.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        @if(request()->routeIs('kabar-pondok.*'))
                            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-emerald-600 rounded-full"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-1 tracking-tight truncate w-full text-center">Kabar</span>
                </a>

                <!-- 4. Tombol Aksi Utama Berdasarkan Role Pengguna (Struktur Ikon Seragam & Stabil) -->
                @if(auth()->user()->role === 'keamanan')
                    <a href="{{ route('keamanan.scanner') }}" class="group flex flex-col items-center justify-center py-1 rounded-xl transition-colors duration-200 {{ request()->routeIs('keamanan.scanner') ? 'text-emerald-700 font-bold bg-emerald-50/70' : 'text-slate-500 hover:text-emerald-700 hover:bg-slate-50 font-medium' }}">
                        <div class="relative transition-colors duration-200 {{ request()->routeIs('keamanan.scanner') ? 'text-emerald-700' : 'text-slate-500 group-hover:text-emerald-700' }}">
                            <svg class="w-5 h-5 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            @if(request()->routeIs('keamanan.scanner'))
                                <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-emerald-600 rounded-full"></span>
                            @endif
                        </div>
                        <span class="text-[10px] mt-1 tracking-tight truncate w-full text-center">Scanner Pos</span>
                    </a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="group flex flex-col items-center justify-center py-1 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.*') ? 'text-amber-700 font-bold bg-amber-50/70' : 'text-slate-500 hover:text-amber-700 hover:bg-slate-50 font-medium' }}">
                        <div class="relative transition-colors duration-200 {{ request()->routeIs('admin.*') ? 'text-amber-700' : 'text-slate-500 group-hover:text-amber-700' }}">
                            <svg class="w-5 h-5 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            @if(request()->routeIs('admin.*'))
                                <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-amber-600 rounded-full"></span>
                            @endif
                        </div>
                        <span class="text-[10px] mt-1 tracking-tight truncate w-full text-center">Panel Admin</span>
                    </a>
                @else
                    <a href="{{ route('kartu-alumni') }}" class="group flex flex-col items-center justify-center py-1 rounded-xl transition-colors duration-200 {{ request()->routeIs('kartu-alumni') ? 'text-emerald-700 font-bold bg-emerald-50/70' : 'text-slate-500 hover:text-emerald-700 hover:bg-slate-50 font-medium' }}">
                        <div class="relative transition-colors duration-200 {{ request()->routeIs('kartu-alumni') ? 'text-emerald-700' : 'text-slate-500 group-hover:text-emerald-700' }}">
                            <svg class="w-5 h-5 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            @if(request()->routeIs('kartu-alumni'))
                                <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-emerald-600 rounded-full"></span>
                            @endif
                        </div>
                        <span class="text-[10px] mt-1 tracking-tight truncate w-full text-center">Kartu QR</span>
                    </a>
                @endif

                <!-- 5. Profil -->
                <a href="{{ route('profil.index') }}" class="group flex flex-col items-center justify-center py-1 rounded-xl transition-colors duration-200 {{ request()->routeIs('profil.*') ? 'text-emerald-700 font-bold bg-emerald-50/70' : 'text-slate-500 hover:text-emerald-700 hover:bg-slate-50 font-medium' }}">
                    <div class="relative transition-colors duration-200 {{ request()->routeIs('profil.*') ? 'text-emerald-700' : 'text-slate-500 group-hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 transition-colors duration-200" fill="{{ request()->routeIs('profil.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        @if(request()->routeIs('profil.*'))
                            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-emerald-600 rounded-full"></span>
                        @endif
                    </div>
                    <span class="text-[10px] mt-1 tracking-tight truncate w-full text-center">Profil</span>
                </a>

            </div>
        </nav>

        <!-- Footer Section with Ponpes Information, Location Map & Social Media Links -->
        <footer class="mt-auto w-full border-t border-slate-200/80 bg-slate-100/70 backdrop-blur-sm" :class="isMobileView ? 'pb-20' : ''">
            <!-- Upper Section: Informasi Ponpes & Peta Lokasi Cards -->
            <div :class="isMobileView ? 'px-4 py-6' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    
                    <!-- Card 1: Informasi & Kontak Kami -->
                    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3.5">
                            <div class="flex items-center space-x-2.5 border-b border-slate-100 pb-2.5">
                                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <h3 class="font-extrabold text-sm sm:text-base text-slate-800">Informasi & Kontak Kami</h3>
                            </div>

                            <div class="space-y-3 text-xs text-slate-600">
                                <!-- Alamat -->
                                <div class="flex items-start space-x-3">
                                    <div class="w-6 h-6 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <span class="leading-relaxed font-medium">Jl. Solo-Purwodadi Km.8, Selokaton, Gondangrejo, Karanganyar, Jawa Tengah 57773</span>
                                </div>

                                <!-- Email -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-6 h-6 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <a href="mailto:pondok@bukhari.or.id" class="text-slate-700 hover:text-emerald-700 font-semibold transition">pondok@bukhari.or.id</a>
                                </div>

                                <!-- Jam Kantor -->
                                <div class="flex items-center space-x-3">
                                    <div class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <span class="font-medium">Jam kantor: 07.30 – 14.30 (setiap hari)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Brand/Emblem subtext -->
                        <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                            <span class="flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                <span>Pondok Pesantren Imam Bukhari</span>
                            </span>
                            <span class="font-semibold text-emerald-800/80">IKLIMB Apps</span>
                        </div>
                    </div>

                    <!-- Card 2: Peta Lokasi -->
                    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                </div>
                                <h3 class="font-extrabold text-sm sm:text-base text-slate-800">Peta Lokasi</h3>
                            </div>
                            <a href="https://www.google.com/maps?ll=-7.493783,110.813141&z=13&t=m&hl=en-US&gl=US&mapclient=embed&q=Pondok+Pesantren+Imam+Bukhari+Karanganyar" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200 inline-flex items-center space-x-1.5 shadow-sm transition">
                                <span>Open in Maps</span>
                                <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>

                        <!-- Embedded Interactive Map -->
                        <div class="w-full h-40 sm:h-44 rounded-2xl overflow-hidden border border-slate-200 shadow-inner relative">
                            <iframe src="https://maps.google.com/maps?q=Pondok+Pesantren+Imam+Bukhari+Karanganyar&t=&z=14&ie=UTF8&iwloc=&output=embed" class="w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta Lokasi Pondok Pesantren Imam Bukhari"></iframe>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bottom Green Banner (Matching user request & Image 1/2) -->
            <div class="bg-gradient-to-r from-emerald-950 via-emerald-800 to-emerald-950 text-white border-t border-gold-400/20 shadow-lg">
                <div :class="isMobileView ? 'px-4 py-3.5' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5'" class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    
                    <!-- Left: Copyright Ponpes -->
                    <div class="flex items-center space-x-2 text-center sm:text-left">
                        <span class="text-emerald-100 font-medium tracking-wide">&copy; {{ date('Y') }} Pondok Pesantren Imam Bukhari</span>
                    </div>

                    <!-- Right: Social Media & Contact Links -->
                    <div class="flex items-center space-x-2 sm:space-x-2.5">
                        <!-- WhatsApp Contact Person -->
                        <a href="https://api.whatsapp.com/send/?phone=62271858199&text&type=phone_number&app_absent=0" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-emerald-600 hover:text-white text-emerald-200 flex items-center justify-center transition shadow-sm hover:scale-110 active:scale-95" title="WhatsApp Ponpes Imam Bukhari">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>

                        <!-- YouTube -->
                        <a href="https://www.youtube.com/channel/UCft1n9iqYGn81xf4E1yPxCA" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-rose-600 hover:text-white text-emerald-200 flex items-center justify-center transition shadow-sm hover:scale-110 active:scale-95" title="YouTube PPIB Official">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>

                        <!-- Instagram -->
                        <a href="https://www.instagram.com/pondokpesantrenimambukhari/" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-pink-600 hover:text-white text-emerald-200 flex items-center justify-center transition shadow-sm hover:scale-110 active:scale-95" title="Instagram @pondokpesantrenimambukhari">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/MahadImamBukhari/" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-blue-600 hover:text-white text-emerald-200 flex items-center justify-center transition shadow-sm hover:scale-110 active:scale-95" title="Facebook Mahad Imam Bukhari">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>

                        <!-- X (Twitter) -->
                        <a href="https://x.com/ppib_official" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-slate-900 hover:text-white text-emerald-200 flex items-center justify-center transition shadow-sm hover:scale-110 active:scale-95" title="X (Twitter) @ppib_official">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    </div>

                </div>
            </div>
        </footer>

    </div>

    <!-- Layout & PWA Script -->
    <script>
        function responsiveLayout() {
            return {
                windowWidth: window.innerWidth,

                initLayout() {
                    if (localStorage.getItem('iklimb_view_mode')) {
                        localStorage.removeItem('iklimb_view_mode');
                    }
                    window.addEventListener('resize', () => {
                        this.windowWidth = window.innerWidth;
                    });
                },

                get isMobileView() {
                    return this.windowWidth < 1024;
                },

                get mode() {
                    return this.isMobileView ? 'mobile' : 'desktop';
                },

                get bodyClass() {
                    return 'bg-slate-50 flex flex-col min-h-screen text-slate-800 antialiased';
                },

                get containerClass() {
                    return 'w-full min-h-screen flex flex-col bg-slate-50 transition-all duration-200';
                }
            }
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('IKLIMB PWA ServiceWorker registered with scope:', registration.scope);
                    })
                    .catch((err) => {
                        console.log('IKLIMB PWA ServiceWorker registration failed:', err);
                    });
            });
        }

        // Automatic scroll reveal for elegant animations when scrolling down
        document.addEventListener('DOMContentLoaded', () => {
            if ('IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            revealObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.05,
                    rootMargin: '0px 0px -30px 0px'
                });

                document.querySelectorAll('.scroll-reveal').forEach(el => {
                    revealObserver.observe(el);
                });
            } else {
                document.querySelectorAll('.scroll-reveal').forEach(el => {
                    el.classList.add('is-revealed');
                });
            }
        });
    </script>

    <!-- Floating Scroll to Top Button -->
    <button 
        x-data="{ showTop: false }"
        @scroll.window="showTop = (window.pageYOffset > 300)"
        x-show="showTop"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        type="button"
        class="fixed right-4 bottom-20 lg:bottom-8 z-30 p-2.5 sm:p-3 rounded-full bg-emerald-800/90 hover:bg-emerald-700 text-gold-300 hover:text-white shadow-xl border border-gold-400/50 backdrop-blur-sm transition-all duration-200 hover:scale-105 active:scale-95 cursor-pointer"
        title="Scroll ke atas">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
    </button>
    @stack('scripts')
</body>
</html>
