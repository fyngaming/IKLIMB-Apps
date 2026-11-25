@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Kabar Pondok PPIB</h1>
            <p class="text-xs text-slate-500">Berita, pengumuman, dan agenda kegiatan resmi.</p>
        </div>
        @if(in_array(auth()->user()->role, ['admin', 'koordinator']))
            <div class="flex items-center space-x-2">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.kabar.index') }}" class="py-1.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs shadow-sm flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Kelola Warta</span>
                    </a>
                @endif
                <a href="{{ route('kabar-pondok.create') }}" class="py-1.5 px-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow flex items-center space-x-1">
                    <span>+ Tulis Kabar</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Category Filters -->
    <div class="flex space-x-2 overflow-x-auto pb-1 scrollbar-none">
        @foreach($kategoriList as $kat)
            <a href="{{ route('kabar-pondok.index', ['kategori' => $kat]) }}"
                class="px-3 py-1.5 rounded-full text-xs font-bold transition flex-shrink-0 {{ ($kategori == $kat || (!$kategori && $kat == 'Semua')) ? 'bg-emerald-800 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ $kat }}
            </a>
        @endforeach
    </div>

    <!-- Articles List (Responsive Grid: 1 col on mobile, 2 col on md, 3 col on lg) -->
    <div class="space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 space-y-0 responsive-grid-3">
        @forelse($kabarList as $kabar)
            <a href="{{ route('kabar-pondok.show', $kabar->slug) }}" class="block bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md hover:border-emerald-500 transition flex flex-col justify-between">
                <div>
                    <div class="h-40 bg-slate-100 relative">
                        <img src="{{ $kabar->gambar ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover">
                        <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-900/90 text-gold-300 backdrop-blur-sm">
                            {{ $kabar->kategori }}
                        </span>
                        @if($kabar->is_pinned)
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950 shadow-sm inline-flex items-center space-x-1">
                                <svg class="w-3 h-3 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                <span>Pinned</span>
                            </span>
                        @endif
                    </div>

                    <div class="p-4 space-y-1.5">
                        <h2 class="font-bold text-sm text-slate-800 hover:text-emerald-700 leading-snug line-clamp-2">{{ $kabar->judul }}</h2>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $kabar->ringkasan }}</p>
                    </div>
                </div>

                <div class="px-4 pb-3.5 pt-0">
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-[10px] text-slate-400">
                        <span>{{ $kabar->published_at ? $kabar->published_at->format('d M Y') : 'Baru' }}</span>
                        <span>{{ $kabar->views_count }} dibaca</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-3 bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-500 text-xs">
                Belum ada kabar pada kategori ini.
            </div>
        @endforelse
        </div>

        {{ $kabarList->links() }}
    </div>
</div>
@endsection
