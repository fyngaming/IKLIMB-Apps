@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4">
    <div class="flex items-center space-x-2 border-b pb-3 border-slate-200">
        <a href="{{ route('kabar-pondok.index') }}" class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">
            &larr;
        </a>
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Tulis Kabar Pondok</h1>
            <p class="text-xs text-slate-500">Publikasi berita & pengumuman untuk seluruh alumni.</p>
        </div>
    </div>

    <form action="{{ route('kabar-pondok.store') }}" method="POST" class="space-y-3.5">
        @csrf
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Berita/Pengumuman <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Tuliskan judul kabar..."
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                    <select name="kategori" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl">
                        <option value="Berita">Berita</option>
                        <option value="Pengumuman">Pengumuman</option>
                        <option value="Agenda">Agenda</option>
                        <option value="Prestasi">Prestasi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">URL Gambar Sampul</label>
                    <input type="url" name="gambar" value="{{ old('gambar') }}" placeholder="https://..."
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Ringkasan Singkat</label>
                <textarea name="ringkasan" rows="2" placeholder="1-2 kalimat ringkasan..."
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl">{{ old('ringkasan') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Konten Lengkap <span class="text-rose-500">*</span></label>
                <textarea name="konten" rows="6" required placeholder="Tulis isi kabar secara detail..."
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl">{{ old('konten') }}</textarea>
            </div>

            <div>
                <label class="flex items-center space-x-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_pinned" value="1" class="w-4 h-4 text-emerald-600 rounded">
                    <span>Sematkan di Atas (Pinned Article)</span>
                </label>
            </div>
        </div>

        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-sm shadow transition">
            Terbitkan Kabar Pondok
        </button>
    </form>
</div>
@endsection
