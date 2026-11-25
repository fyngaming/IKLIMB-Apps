<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#065f46">
    <title>{{ $title ?? 'Autentikasi' }} - IKLIMB Apps PPIB</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" sizes="64x64" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 bg-gradient-to-br from-emerald-950 via-slate-900 to-emerald-950 text-slate-800 antialiased relative">

    <div class="w-full max-w-md min-h-0 bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col justify-between border border-gold-400/40 transition-all duration-300 relative z-10">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-br from-emerald-950 via-emerald-800 to-emerald-950 p-6 text-center text-white relative">
            <div class="inline-flex w-20 h-20 rounded-3xl bg-white p-2 border-2 border-gold-400 items-center justify-center shadow-2xl mb-3 group hover:scale-105 transition">
                <img src="/images/logo-ppib.png" alt="Logo PPIB" class="w-full h-full object-contain">
            </div>
            <h1 class="text-xl font-extrabold tracking-wide text-white">IKLIMB Apps</h1>
            <p class="text-xs text-emerald-200 mt-1">Ikatan Keluarga Alumni Pondok Pesantren PPIB</p>
            <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-12 h-1 bg-gold-400 rounded-full"></div>
        </div>

        <!-- Notification Alerts -->
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center space-x-2">
                    <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-3 bg-amber-50 border border-amber-200 text-amber-900 text-xs rounded-xl flex items-center space-x-2">
                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Form / View Body -->
        <div class="p-6 flex-1">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="p-4 bg-slate-50 border-t border-slate-100 text-center text-[11px] text-slate-500">
            &copy; {{ date('Y') }} IKLIMB &bull; Pondok Pesantren PPIB.
        </div>
    </div>

    <script>
        // Bersihkan cache manual jika sebelumnya pernah tersimpan agar selalu otomatis (auto-responsive)
        if (localStorage.getItem('iklimb_view_mode')) {
            localStorage.removeItem('iklimb_view_mode');
        }
    </script>

    @stack('scripts')
</body>
</html>
