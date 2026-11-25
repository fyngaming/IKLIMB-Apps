@extends('layouts.app')

@section('content')
<div class="space-y-5">

    <!-- Header -->
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Kunjungan ke Pondok</h1>
            <p class="text-xs text-slate-500">Ajukan silaturahmi & dapatkan Kode QR masuk pos gerbang.</p>
        </div>
        <a href="{{ route('kunjungan.create') }}" class="py-2 px-3 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 text-white font-bold text-xs shadow flex items-center space-x-1">
            <span class="text-sm">+</span>
            <span>Ajukan Baru</span>
        </a>
    </div>

    <!-- Staff Management Tab if Koordinator / Admin / Keamanan -->
    @if($isStaff && $staffKunjungans)
        <div x-data="{ tab: 'staff' }" class="space-y-3">
            <div class="flex bg-slate-200/80 p-1 rounded-xl text-xs font-bold">
                <button @click="tab = 'staff'" :class="tab === 'staff' ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600'" class="flex-1 py-1.5 rounded-lg transition text-center flex items-center justify-center space-x-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span>Kelola Pengajuan ({{ $staffKunjungans->total() }})</span>
                </button>
                <button @click="tab = 'my'" :class="tab === 'my' ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600'" class="flex-1 py-1.5 rounded-lg transition text-center">
                    Kunjungan Saya ({{ $myKunjungans->total() }})
                </button>
            </div>

            <!-- Staff List -->
            <div x-show="tab === 'staff'" class="space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 space-y-0 responsive-grid-2">
                @forelse($staffKunjungans as $k)
                    <div class="bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm space-y-2.5">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="font-mono text-[10px] text-slate-400 font-bold block">{{ $k->kode_kunjungan }}</span>
                                <h3 class="font-bold text-sm text-slate-800">{{ $k->user->name }}</h3>
                                <p class="text-xs text-slate-500">Tujuan: <span class="font-medium text-slate-700">{{ $k->tujuan }}</span> ({{ $k->pihak_ditemui }})</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                {{ $k->status === 'disetujui' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $k->status === 'menunggu' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $k->status === 'dijadwalkan_ulang' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $k->status === 'selesai' ? 'bg-slate-100 text-slate-800' : '' }}
                                {{ $k->status === 'ditolak' ? 'bg-rose-100 text-rose-800' : '' }}">
                                {{ $k->status }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 p-2 bg-slate-50 rounded-xl text-xs">
                            <div>
                                <span class="text-[10px] text-slate-400 block">Jadwal Tiba:</span>
                                <span class="font-semibold text-slate-700">{{ $k->tanggal_kunjungan->format('d M Y') }} &bull; {{ substr($k->jam_kunjungan, 0, 5) }} WIB</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 block">Rombongan:</span>
                                <span class="font-semibold text-slate-700">{{ $k->jumlah_rombongan }} Org ({{ $k->is_menginap ? 'Menginap' : 'Tidak Menginap' }})</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 pt-1 border-t border-slate-100">
                            <a href="{{ route('kunjungan.show', $k->id) }}" class="flex-1 py-1.5 px-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg text-center transition">
                                Buka Detail & Tiket QR &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-2 text-xs text-center text-slate-500 py-6">Tidak ada pengajuan kunjungan saat ini.</p>
                @endforelse
                </div>
                {{ $staffKunjungans->links() }}
            </div>

            <!-- My Visits inside Tab -->
            <div x-show="tab === 'my'" class="space-y-3">
                @include('kunjungan.partials.my-list')
            </div>
        </div>
    @else
        <!-- Alumni Only List -->
        @include('kunjungan.partials.my-list')
    @endif

</div>
@endsection
