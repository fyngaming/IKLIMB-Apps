@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <!-- Breadcrumb & Top Nav -->
    <div class="flex items-center space-x-2 text-xs pb-3 border-b border-slate-200">
        <a href="{{ route('home') }}" class="text-slate-500 hover:text-emerald-700 transition">Beranda</a>
        <span class="text-slate-400">/</span>
        <a href="{{ route('kabar-pondok.index') }}" class="text-slate-500 hover:text-emerald-700 transition">Kabar Pondok</a>
        <span class="text-slate-400">/</span>
        <span class="font-bold text-slate-800 line-clamp-1">{{ $kabar->judul }}</span>
    </div>

    <!-- Article Detail -->
    <article class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="h-48 bg-slate-100 relative">
            <img src="{{ $kabar->gambar ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover">
            <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-900/90 text-gold-300">
                {{ $kabar->kategori }}
            </span>
        </div>

        <div class="p-5 space-y-3">
            <h1 class="text-lg font-extrabold text-slate-900 leading-snug">{{ $kabar->judul }}</h1>
            
            <div class="flex items-center justify-between text-xs text-slate-400 pb-3 border-b border-slate-100">
                <span>Diterbitkan: {{ $kabar->published_at ? $kabar->published_at->format('d M Y H:i') : '-' }}</span>
                <span>{{ $kabar->views_count }} x dibaca</span>
            </div>

            <div class="prose prose-sm text-slate-700 leading-relaxed space-y-3 text-xs sm:text-sm">
                {!! nl2br(e($kabar->konten)) !!}
            </div>
        </div>
    </article>

    <!-- Related Articles -->
    @if($relatedKabar->isNotEmpty())
        <div class="space-y-2 pt-2">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Kabar Terkait Lainnya</h3>
            <div class="space-y-2">
                @foreach($relatedKabar as $rel)
                    <a href="{{ route('kabar-pondok.show', $rel->slug) }}" class="flex items-center space-x-3 p-2.5 bg-white rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-500 transition">
                        <img src="{{ $rel->gambar }}" alt="{{ $rel->judul }}" class="w-14 h-14 rounded-xl object-cover flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-xs text-slate-800 line-clamp-1">{{ $rel->judul }}</h4>
                            <span class="text-[10px] text-slate-400 mt-1 block">{{ $rel->published_at ? $rel->published_at->format('d M Y') : '' }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
