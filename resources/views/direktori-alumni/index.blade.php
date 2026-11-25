@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
        <div>
            <span class="text-[10px] uppercase font-bold text-emerald-700 tracking-wider">Jejaring Alumni</span>
            <h1 class="text-base font-extrabold text-slate-800">Direktori Alumni PPIB</h1>
            <p class="text-xs text-slate-500">Temukan rekan sealmamater lintas angkatan & daerah.</p>
        </div>
    </div>

    <!-- Search & Filters -->
    <form action="{{ route('direktori-alumni.index') }}" method="GET" class="bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm space-y-2 md:space-y-0 md:flex md:items-center md:space-x-3">
        <div class="relative flex-1">
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, kota, profesi, atau instansi..."
                class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div class="grid grid-cols-2 md:flex md:items-center gap-2 text-xs">
            <select name="angkatan" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold">
                <option value="">Semua Angkatan</option>
                @foreach($angkatanList as $a)
                    <option value="{{ $a }}" {{ $angkatan == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
            </select>
            <button type="submit" class="py-2 px-4 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-bold shadow-sm transition">
                Filter
            </button>
        </div>
    </form>

    <!-- Alumni Cards List (Responsive Grid: 1 col on mobile, 2 col on md, 3 col on lg) -->
    <div class="space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5 space-y-0 responsive-grid-3">
        @forelse($alumniList as $alumni)
            @php $prof = $alumni->alumniProfile; @endphp
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-2.5 flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition">
                <div class="space-y-2.5">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-10 h-10 rounded-full bg-emerald-800 text-gold-300 flex items-center justify-center font-bold text-sm shadow flex-shrink-0">
                                {{ strtoupper(substr($alumni->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-slate-800 line-clamp-1">{{ $alumni->name }}</h3>
                                <span class="text-[10px] text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                    {{ $prof->angkatan ?? 'Alumni' }} &bull; {{ $prof->jenjang_pondok ?? 'PPIB' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Controlled Data Details -->
                    <div class="p-2.5 bg-slate-50 rounded-xl text-xs space-y-1">
                        @if($prof && $prof->canShowJob() && $prof->pekerjaan_lembaga)
                            <div class="flex items-center space-x-1.5 text-slate-700">
                                <svg class="w-3.5 h-3.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="line-clamp-1">{{ $prof->pekerjaan_jabatan ? $prof->pekerjaan_jabatan . ' - ' : '' }}{{ $prof->pekerjaan_lembaga }}</span>
                            </div>
                        @endif

                        @if($prof && $prof->canShowAddress() && $prof->kabupaten_kota)
                            <div class="flex items-center space-x-1.5 text-slate-600">
                                <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="line-clamp-1">{{ $prof->kabupaten_kota }}, {{ $prof->provinsi }}</span>
                            </div>
                        @endif

                        @if($prof && $prof->canShowEducation() && $prof->educations->isNotEmpty())
                            <div class="flex items-center space-x-1.5 text-slate-600">
                                <svg class="w-3.5 h-3.5 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                                <span class="line-clamp-1">{{ $prof->educations->first()->jenjang }} {{ $prof->educations->first()->nama_universitas }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if($prof && $prof->canShowWa())
                    <div class="pt-2 flex items-center justify-between text-xs border-t border-slate-100">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $alumni->no_wa) }}" target="_blank" class="py-1.5 px-3 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs flex items-center space-x-1 shadow-sm transition">
                            <span>Hubungi WA &rarr;</span>
                        </a>
                        <span class="text-[10px] text-slate-400 font-mono">{{ substr($alumni->no_wa, 0, 6) }}****</span>
                    </div>
                @else
                    <div class="pt-2 text-[10px] text-slate-400 italic text-right border-t border-slate-100">
                        Kontak disembunyikan
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-3 bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-500 text-xs">
                Tidak ada data alumni yang cocok dengan pencarian Anda.
            </div>
        @endforelse
        </div>

        {{ $alumniList->links() }}
    </div>
</div>
@endsection
