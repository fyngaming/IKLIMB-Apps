@extends('layouts.app')

@section('content')
<div class="space-y-5" x-data="{ showForm: false }">
    <div class="flex items-center justify-between border-b pb-3 border-slate-200">
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Tanya Ustaz PPIB</h1>
            <p class="text-xs text-slate-500">Konsultasi keagamaan, fiqih, & muamalah.</p>
        </div>
        <button type="button" @click="showForm = !showForm" class="py-1.5 px-3 rounded-xl bg-emerald-800 text-white font-bold text-xs shadow">
            <span x-text="showForm ? 'Tutup' : '+ Buat Pertanyaan'"></span>
        </button>
    </div>

    <!-- Question Form -->
    <div x-show="showForm" x-cloak class="bg-white p-4 rounded-3xl border-2 border-emerald-500 shadow-md space-y-3">
        <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider border-b pb-2">Kirim Pertanyaan Baru</h2>
        <form action="{{ route('tanya-ustaz.store') }}" method="POST" class="space-y-3 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Bidang / Kategori</label>
                <select name="kategori_keilmuan" class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg">
                    <option value="Fiqih Ibadah">Fiqih Ibadah</option>
                    <option value="Muamalah & Bisnis">Muamalah & Bisnis Kontemporer</option>
                    <option value="Keluarga & Pernikahan">Keluarga & Pernikahan</option>
                    <option value="Aqidah">Aqidah</option>
                    <option value="Akhlaq & Adab">Akhlaq & Adab</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Judul Pertanyaan</label>
                <input type="text" name="judul_pertanyaan" required placeholder="Pokok pertanyaan..." class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Detail Pertanyaan</label>
                <textarea name="pertanyaan" rows="3" required placeholder="Jelaskan pertanyaan Anda dengan jelas..." class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg"></textarea>
            </div>
            <div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_anonim" value="1" class="w-4 h-4 text-emerald-600 rounded">
                    <span>Ajukan secara Anonim (Nama dirahasiakan)</span>
                </label>
            </div>
            <button type="submit" class="w-full py-2 bg-emerald-800 text-white font-bold rounded-lg shadow">Kirim ke Ustaz</button>
        </form>
    </div>

    <!-- Answered Questions List -->
    <div class="space-y-3">
        <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Arsip Tanya Jawab Asatizah</h2>
        @forelse($publicAnswers as $q)
            <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-2.5">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-[9px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 font-bold uppercase">{{ $q->kategori_keilmuan }}</span>
                        <h3 class="font-extrabold text-sm text-slate-800 mt-1">{{ $q->judul_pertanyaan }}</h3>
                        <p class="text-[11px] text-slate-500">Penanya: {{ $q->is_anonim ? 'Hamba Allah (Anonim)' : $q->penanya->name }}</p>
                    </div>
                </div>

                <div class="p-2.5 bg-slate-50 rounded-xl text-xs text-slate-700 italic border-l-2 border-slate-300">
                    "{{ $q->pertanyaan }}"
                </div>

                <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-200 text-xs space-y-1">
                    <div class="font-bold text-emerald-900 flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span>Jawaban {{ $q->nama_ustaz_penjawab ?? 'Dewan Asatizah PPIB' }}:</span>
                    </div>
                    <p class="text-slate-800 leading-relaxed">{{ $q->jawaban }}</p>
                </div>
            </div>
        @empty
            <p class="text-xs text-center text-slate-500 py-6">Belum ada tanya jawab publik.</p>
        @endforelse
    </div>
</div>
@endsection
