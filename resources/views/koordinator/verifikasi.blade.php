@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
        <div>
            <span class="text-[10px] uppercase font-bold text-emerald-700 tracking-wider">Panel Koordinator</span>
            <h1 class="text-lg font-bold text-slate-800">Verifikasi Pendaftaran Alumni</h1>
            <p class="text-xs text-slate-500">Validasi alumni baru sebelum diberikan tautan aktivasi akun.</p>
        </div>
        <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-800 font-bold text-xs">
            {{ $pendingUsers->total() }} Menunggu
        </span>
    </div>

    <!-- Activation Link Notification Modal / Alert -->
    @if(session('activation_generated'))
        @php $act = session('activation_generated'); @endphp
        <div class="p-4 bg-gradient-to-r from-emerald-900 to-emerald-800 text-white rounded-2xl shadow-xl space-y-3 border-2 border-gold-400">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-gold-400 text-slate-950 flex items-center justify-center font-bold shadow-md">
                    <svg class="w-4 h-4 text-emerald-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-white">Aktivasi Berhasil Diterbitkan!</h3>
                    <p class="text-[11px] text-emerald-200">Untuk: {{ $act['name'] }} ({{ $act['no_wa'] }})</p>
                </div>
            </div>

            <div class="bg-emerald-950/80 p-2.5 rounded-xl border border-emerald-700/60 font-mono text-[11px] break-all select-all text-gold-300">
                {{ $act['url'] }}
            </div>

            <div class="flex items-center space-x-2 pt-1">
                <a href="{{ $act['url'] }}" class="flex-1 py-2 px-3 bg-gold-400 hover:bg-gold-500 text-slate-900 text-xs font-bold rounded-lg text-center shadow">
                    Buka Link Aktivasi Sekarang (Uji Coba) &rarr;
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $act['no_wa']) }}?text={{ urlencode('Assalamu\'alaikum ' . $act['name'] . ', pendaftaran akun IKLIMB Anda telah disetujui. Silakan aktifkan akun dan buat kata sandi Anda melalui tautan berikut: ' . $act['url']) }}" target="_blank" class="py-2 px-3 bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-bold rounded-lg flex items-center space-x-1">
                    <span>Kirim WA</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Pending List -->
    <div class="space-y-3">
        <h2 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Daftar Menunggu Persetujuan</h2>

        @forelse($pendingUsers as $user)
            <div class="bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">{{ $user->name }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">WA: <span class="font-mono font-semibold text-slate-700">{{ $user->no_wa }}</span></p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">
                        Menunggu
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 p-2.5 bg-slate-50 rounded-xl text-xs">
                    <div>
                        <span class="text-[10px] text-slate-400 block">NIS Santri:</span>
                        <span class="font-mono font-bold text-emerald-800">{{ $user->alumniProfile->nis ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Angkatan:</span>
                        <span class="font-semibold text-slate-700">{{ $user->alumniProfile->angkatan ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Jenjang Pondok:</span>
                        <span class="font-semibold text-slate-700">{{ $user->alumniProfile->jenjang_pondok ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Daftar Pada:</span>
                        <span class="text-slate-600">{{ $user->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>

                @if($user->alumniProfile && $user->alumniProfile->masterSantri)
                    <div class="text-[11px] text-emerald-700 bg-emerald-50 px-2.5 py-1.5 rounded-lg flex items-center space-x-1.5 border border-emerald-200">
                        <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Terverifikasi cocok dengan Master Santri PPIB (Nama: <strong>{{ $user->alumniProfile->masterSantri->nama_lengkap }}</strong>)</span>
                    </div>
                @endif

                <div class="flex items-center space-x-2 pt-1 border-t border-slate-100">
                    <form action="{{ route('koordinator.verifikasi.approve', $user->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2 px-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs flex items-center justify-center space-x-1.5 shadow-sm transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Setujui & Terbitkan Link WA</span>
                        </button>
                    </form>

                    <form action="{{ route('koordinator.verifikasi.reject', $user->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran alumni ini?');">
                        @csrf
                        <button type="submit" class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 font-semibold text-xs transition">
                            Tolak
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center text-slate-500 space-y-2">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-bold text-sm text-slate-700">Semua Pendaftaran Bersih!</h3>
                <p class="text-xs">Tidak ada pendaftaran alumni baru yang menunggu verifikasi saat ini.</p>
            </div>
        @endforelse

        {{ $pendingUsers->links() }}
    </div>
</div>
@endsection
