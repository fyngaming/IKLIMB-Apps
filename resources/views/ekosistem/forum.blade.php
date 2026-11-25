@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <div class="flex items-center space-x-2 border-b pb-3 border-slate-200">
        <a href="{{ route('home') }}" class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">&larr;</a>
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Forum WhatsApp Angkatan</h1>
            <p class="text-xs text-slate-500">Tautan resmi grup koordinasi angkatan alumni PPIB.</p>
        </div>
    </div>

    <div class="space-y-3">
        @forelse($forums as $forum)
            <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-2.5">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Lulus Tahun {{ $forum->tahun_lulus }}</span>
                        <h2 class="font-extrabold text-sm text-slate-800">{{ $forum->angkatan }}</h2>
                    </div>
                    <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                        WA
                    </span>
                </div>

                <div class="p-2.5 bg-slate-50 rounded-xl text-xs space-y-1">
                    <div class="text-slate-600">Koordinator: <strong>{{ $forum->nama_koordinator }}</strong></div>
                    <div class="text-slate-500 text-[11px]">{{ $forum->keterangan }}</div>
                </div>

                <a href="{{ $forum->link_wa_group }}" target="_blank" class="block w-full py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl text-center shadow-sm">
                    Gabung Grup WhatsApp Resmi &rarr;
                </a>
            </div>
        @empty
            <p class="text-xs text-center text-slate-500 py-6">Belum ada direktori grup angkatan.</p>
        @endforelse
    </div>
</div>
@endsection
