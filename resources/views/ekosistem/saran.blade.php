@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <div class="flex items-center space-x-2 border-b pb-3 border-slate-200">
        <a href="{{ route('home') }}" class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">&larr;</a>
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Saran & Masukan Alumni</h1>
            <p class="text-xs text-slate-500">Salurkan aspirasi konstruktif untuk kemajuan PPIB.</p>
        </div>
    </div>

    <!-- Submit Form -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-3">
        <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider border-b pb-2">+ Sampaikan Aspirasi / Masukan</h2>

        <form action="{{ route('saran-masukan.store') }}" method="POST" class="space-y-3 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Topik Masukan</label>
                <select name="topik" class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg">
                    <option value="Pengembangan Pondok & Sarpras">Pengembangan Pondok & Sarpras</option>
                    <option value="Kurikulum & Pembinaan Santri">Kurikulum & Pembinaan Santri</option>
                    <option value="Jejaring Alumni & Sinergi">Jejaring Alumni & Sinergi Bisnis/Dakwah</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Isi Masukan / Aspirasi</label>
                <textarea name="isi_aspirasi" rows="3" required placeholder="Tuliskan aspirasi Anda dengan santun dan konstruktif..." class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg"></textarea>
            </div>
            <button type="submit" class="w-full py-2 bg-emerald-800 text-white font-bold rounded-lg shadow">Kirim Aspirasi</button>
        </form>
    </div>

    <!-- History -->
    @if($myAspirasi->isNotEmpty())
        <div class="space-y-2">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Aspirasi Saya Sebelumnya</h2>
            @foreach($myAspirasi as $a)
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm text-xs space-y-1.5">
                    <div class="flex justify-between items-start">
                        <span class="font-bold text-slate-800">{{ $a->topik }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">{{ $a->status }}</span>
                    </div>
                    <p class="text-slate-600">{{ $a->isi_aspirasi }}</p>
                    @if($a->tanggapan_pondok)
                        <div class="p-2 bg-emerald-50 rounded-xl border border-emerald-200 text-emerald-900 mt-1">
                            <span class="font-bold block text-[10px]">Tanggapan Pengurus PPIB:</span>
                            <span class="text-[11px]">{{ $a->tanggapan_pondok }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
