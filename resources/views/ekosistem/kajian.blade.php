@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between border-b pb-3 border-slate-200">
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}" class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">&larr;</a>
            <div>
                <h1 class="text-base font-extrabold text-slate-800">Kajian & Materi Keilmuan</h1>
                <p class="text-xs text-slate-500">Kumpulan rekaman daurah & tulisan asatizah PPIB.</p>
            </div>
        </div>
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.kajian.index') }}" class="px-3 py-1.5 rounded-xl bg-purple-700 hover:bg-purple-800 text-white font-bold text-xs shadow-sm transition">
                + Kelola Kajian
            </a>
        @endif
    </div>

    <div class="space-y-3">
        @forelse($kajianList as $kajian)
            <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-purple-100 text-purple-800 font-bold uppercase">{{ $kajian->kategori }}</span>
                        <h2 class="font-extrabold text-sm text-slate-900 mt-1">{{ $kajian->judul }}</h2>
                        <p class="text-xs text-emerald-800 font-medium">Oleh: {{ $kajian->nama_narasumber }}</p>
                    </div>
                </div>

                <p class="text-xs text-slate-600 leading-relaxed">{{ $kajian->ringkasan }}</p>

                @if($kajian->media_url)
                    <div class="pt-2 border-t border-slate-100">
                        <a href="{{ $kajian->media_url }}" target="_blank" class="inline-flex items-center space-x-1.5 py-1.5 px-3 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs shadow-sm">
                            <span>▶ Tonton / Dengarkan Materi</span>
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-xs text-center text-slate-500 py-6">Belum ada materi kajian terunggah.</p>
        @endforelse
    </div>
</div>
@endsection
