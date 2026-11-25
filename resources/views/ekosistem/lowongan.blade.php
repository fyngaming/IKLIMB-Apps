@extends('layouts.app')

@section('content')
<div class="space-y-5" x-data="{ showForm: false }">
    <div class="flex items-center justify-between border-b pb-3 border-slate-200">
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Lowongan & Usaha Alumni</h1>
            <p class="text-xs text-slate-500">Pemberdayaan ekonomi & peluang dakwah santri.</p>
        </div>
        <button type="button" @click="showForm = !showForm" class="py-1.5 px-3 rounded-xl bg-emerald-800 text-white font-bold text-xs shadow">
            <span x-text="showForm ? 'Tutup Form' : '+ Pasang Info'"></span>
        </button>
    </div>

    <!-- Create Form -->
    <div x-show="showForm" x-cloak class="bg-white p-4 rounded-3xl border-2 border-emerald-500 shadow-md space-y-3">
        <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider border-b pb-2">Pasang Lowongan / Usaha Baru</h2>
        <form action="{{ route('info-lowongan-usaha.store') }}" method="POST" class="space-y-2.5 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Kategori</label>
                <select name="tipe" class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg">
                    <option value="lowongan_kerja">Lowongan Kerja (Karyawan/Staff)</option>
                    <option value="kebutuhan_dai">Kebutuhan Da'i / Guru Pengajar</option>
                    <option value="usaha_alumni">Katalog Produk / Usaha Alumni</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Judul</label>
                <input type="text" name="judul" required placeholder="Contoh: Dibutuhkan Guru Bahasa Arab / Jasa Ekspedisi" class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Nama Perusahaan / Lembaga / Brand</label>
                <input type="text" name="nama_perusahaan_usaha" required class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block font-semibold text-slate-700 mb-0.5">Lokasi</label>
                    <input type="text" name="lokasi" required placeholder="Jakarta / Online" class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-0.5">Kontak WhatsApp</label>
                    <input type="text" name="kontak_wa" required placeholder="08123..." class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg">
                </div>
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-0.5">Deskripsi Lengkap</label>
                <textarea name="deskripsi" rows="3" required placeholder="Syarat, kualifikasi, atau spesifikasi usaha..." class="w-full px-2.5 py-1.5 bg-slate-50 border rounded-lg"></textarea>
            </div>
            <button type="submit" class="w-full py-2 bg-emerald-800 text-white font-bold rounded-lg shadow">Publikasikan</button>
        </form>
    </div>

    <!-- Items List -->
    <div class="space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 space-y-0 responsive-grid-2">
        @forelse($items as $item)
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-2 flex flex-col justify-between hover:shadow-md transition">
                <div class="space-y-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[9px] px-2 py-0.5 rounded-full font-bold uppercase
                                {{ $item->tipe === 'lowongan_kerja' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $item->tipe === 'kebutuhan_dai' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $item->tipe === 'usaha_alumni' ? 'bg-amber-100 text-amber-800' : '' }}">
                                {{ str_replace('_', ' ', $item->tipe) }}
                            </span>
                            <h3 class="font-bold text-sm text-slate-800 mt-1">{{ $item->judul }}</h3>
                            <p class="text-xs text-slate-500 flex items-center space-x-1.5 mt-0.5">
                                <span>{{ $item->nama_perusahaan_usaha }}</span>
                                <span>&bull;</span>
                                <svg class="w-3.5 h-3.5 text-emerald-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $item->lokasi }}</span>
                            </p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed">{{ $item->deskripsi }}</p>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-[11px] text-slate-400">Oleh: {{ $item->user->name }}</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->kontak_wa) }}" target="_blank" class="py-1 px-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-lg flex items-center space-x-1 shadow-sm">
                        <span>Hubungi WA &rarr;</span>
                    </a>
                </div>
            </div>
        @empty
            <p class="col-span-2 text-xs text-center text-slate-500 py-6">Belum ada info lowongan atau usaha yang dipasang.</p>
        @endforelse
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection
