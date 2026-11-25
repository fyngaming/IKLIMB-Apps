@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <div class="flex items-center space-x-2 border-b pb-3 border-slate-200">
        <a href="{{ route('home') }}" class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">&larr;</a>
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Agenda & Reuni Alumni</h1>
            <p class="text-xs text-slate-500">Temu angkatan, silaturahmi akbar, dan kajian rutin.</p>
        </div>
    </div>

    <div class="space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 space-y-0 responsive-grid-2">
        @forelse($agendas as $agenda)
            @php
                $myRsvp = $agenda->rsvps->where('user_id', auth()->id())->first();
            @endphp
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-4 space-y-3 flex flex-col justify-between hover:shadow-md transition">
                <div class="space-y-2.5">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold uppercase">{{ $agenda->kategori }}</span>
                            <h2 class="font-bold text-sm text-slate-800 mt-1">{{ $agenda->judul }}</h2>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed">{{ $agenda->deskripsi }}</p>

                    <div class="grid grid-cols-2 gap-2 p-2.5 bg-slate-50 rounded-xl text-xs">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Waktu:</span>
                            <span class="font-semibold text-slate-700">{{ $agenda->tanggal_mulai->format('d M Y H:i') }} WIB</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 block">Lokasi:</span>
                            <span class="font-semibold text-slate-700">{{ $agenda->lokasi }}</span>
                        </div>
                    </div>
                </div>

                <!-- RSVP Section -->
                <div class="pt-2 border-t border-slate-100 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-700">Konfirmasi Kehadiran (RSVP):</span>
                        @if($myRsvp)
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                {{ $myRsvp->status_kehadiran }} ({{ $myRsvp->jumlah_tamu }} org)
                            </span>
                        @endif
                    </div>

                    <form action="{{ route('agenda-reuni.rsvp', $agenda->id) }}" method="POST" class="flex items-center space-x-2 text-xs">
                        @csrf
                        <select name="status_kehadiran" class="px-2.5 py-1.5 bg-slate-50 border rounded-lg text-xs font-semibold">
                            <option value="Hadir" {{ optional($myRsvp)->status_kehadiran === 'Hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="Tidak Hadir" {{ optional($myRsvp)->status_kehadiran === 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                            <option value="Ragu-ragu" {{ optional($myRsvp)->status_kehadiran === 'Ragu-ragu' ? 'selected' : '' }}>Ragu-ragu</option>
                        </select>
                        <input type="number" name="jumlah_tamu" value="{{ optional($myRsvp)->jumlah_tamu ?? 1 }}" min="1" max="10" title="Jumlah Tamu" placeholder="Jml" class="w-16 px-2 py-1.5 bg-slate-50 border rounded-lg text-xs text-center font-bold">
                        <button type="submit" class="flex-1 py-1.5 px-3 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-lg shadow-sm">
                            Kirim RSVP
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-2 text-xs text-center text-slate-500 py-6">Belum ada agenda kegiatan mendatang.</p>
        @endforelse
        </div>
    </div>
</div>
@endsection
