@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showCreateModal: false, showEditModal: false, selectedKajian: {} }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-4 border-slate-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700">&larr; Panel Admin</a>
                <span>/</span>
                <span class="font-bold text-slate-800">Manajemen Kajian & Keilmuan</span>
            </div>
            <h1 class="text-xl font-black text-slate-900">Kelola Kajian, Daurah & Materi Kitab</h1>
            <p class="text-xs text-slate-500">Unggah rekaman kajian YouTube/Audio para asatizah, modul daurah, dan materi keislaman untuk alumni.</p>
        </div>
        <button type="button" @click="showCreateModal = true" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 text-white font-bold text-xs shadow-md transition flex items-center space-x-2 self-start sm:self-auto">
            <span class="text-base font-bold">+</span>
            <span>Tambah Kajian Baru</span>
        </button>
    </div>

    <!-- Kajian Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 responsive-grid-2">
        @foreach($kajianList as $kajian)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 font-bold text-[10px]">{{ $kajian->kategori }}</span>
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px] uppercase">{{ $kajian->media_type }}</span>
                    </div>

                    <div>
                        <h3 class="font-extrabold text-base text-slate-900 leading-snug">{{ $kajian->judul }}</h3>
                        <p class="text-xs text-emerald-800 font-semibold mt-0.5 flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            <span>{{ $kajian->nama_narasumber }}</span>
                        </p>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-3 leading-relaxed">{{ $kajian->ringkasan }}</p>
                    </div>

                    @if($kajian->media_url)
                        <div class="pt-1">
                            <a href="{{ $kajian->media_url }}" target="_blank" class="text-[11px] font-bold text-blue-600 hover:underline flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                <span>Buka Link Media / Video</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-[10px] text-slate-400">{{ $kajian->published_at ? $kajian->published_at->format('d M Y') : '' }}</span>
                    <div class="flex items-center space-x-1.5">
                        <button type="button" @click="selectedKajian = {
                            id: {{ $kajian->id }},
                            judul: '{{ addslashes($kajian->judul) }}',
                            nama_narasumber: '{{ addslashes($kajian->nama_narasumber) }}',
                            kategori: '{{ addslashes($kajian->kategori) }}',
                            media_type: '{{ $kajian->media_type }}',
                            media_url: '{{ addslashes($kajian->media_url ?? '') }}',
                            ringkasan: '{{ addslashes($kajian->ringkasan) }}',
                            konten: '{{ addslashes($kajian->konten ?? '') }}'
                        }; showEditModal = true" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                            Edit
                        </button>
                        <form action="{{ route('admin.kajian.destroy', $kajian->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kajian ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1.5 rounded-xl text-rose-600 hover:bg-rose-50 font-bold transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pt-2">
        {{ $kajianList->links() }}
    </div>

    <!-- MODAL 1: TAMBAH KAJIAN BARU -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100" @click.away="showCreateModal = false">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-black text-base text-slate-900">Tambah Materi Kajian / Daurah Baru</h3>
                <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <form action="{{ route('admin.kajian.store') }}" method="POST" class="space-y-3.5 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Kajian / Kitab <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: Kajian Kitab Riyadhus Shalihin: Bab Ikhlas" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pemateri / Ustaz <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_narasumber" required placeholder="Contoh: KH. Abdullah Hakim, Lc." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori Keilmuan <span class="text-rose-500">*</span></label>
                        <select name="kategori" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="Tafsir & Al-Qur'an">Tafsir & Al-Qur'an</option>
                            <option value="Hadits & Sunnah">Hadits & Sunnah</option>
                            <option value="Fiqih Kontemporer">Fiqih Kontemporer</option>
                            <option value="Aqidah & Akhlaq">Aqidah & Akhlaq</option>
                            <option value="Daurah Alumni">Daurah Alumni</option>
                            <option value="Muamalah & Ekonomi">Muamalah & Ekonomi</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tipe Media <span class="text-rose-500">*</span></label>
                        <select name="media_type" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="youtube">Video (YouTube)</option>
                            <option value="audio">Audio / Podcast</option>
                            <option value="artikel">Artikel / Modul Kitab</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Link URL Media (YouTube / Audio)</label>
                        <input type="url" name="media_url" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ringkasan Materi <span class="text-rose-500">*</span></label>
                    <textarea name="ringkasan" rows="2" required placeholder="Ringkasan poin-poin pembahasan kajian..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan Lengkap / Transkrip Materi (Opsional)</label>
                    <textarea name="konten" rows="4" placeholder="Uraian isi kajian atau transkrip faedah ilmiyyah..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="pt-3 border-t flex justify-end space-x-2">
                    <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold shadow-md">Simpan Kajian</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT KAJIAN -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100" @click.away="showEditModal = false">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-black text-base text-slate-900">Perbarui Materi Kajian</h3>
                <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <form :action="'/admin/kajian-materi/' + selectedKajian.id" method="POST" class="space-y-3.5 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Kajian <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" x-model="selectedKajian.judul" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pemateri / Ustaz <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_narasumber" x-model="selectedKajian.nama_narasumber" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                        <select name="kategori" x-model="selectedKajian.kategori" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="Tafsir & Al-Qur'an">Tafsir & Al-Qur'an</option>
                            <option value="Hadits & Sunnah">Hadits & Sunnah</option>
                            <option value="Fiqih Kontemporer">Fiqih Kontemporer</option>
                            <option value="Aqidah & Akhlaq">Aqidah & Akhlaq</option>
                            <option value="Daurah Alumni">Daurah Alumni</option>
                            <option value="Muamalah & Ekonomi">Muamalah & Ekonomi</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tipe Media <span class="text-rose-500">*</span></label>
                        <select name="media_type" x-model="selectedKajian.media_type" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="youtube">Video (YouTube)</option>
                            <option value="audio">Audio / Podcast</option>
                            <option value="artikel">Artikel / Modul Kitab</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Link URL Media</label>
                        <input type="url" name="media_url" x-model="selectedKajian.media_url" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ringkasan Materi <span class="text-rose-500">*</span></label>
                    <textarea name="ringkasan" x-model="selectedKajian.ringkasan" rows="2" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan Lengkap</label>
                    <textarea name="konten" x-model="selectedKajian.konten" rows="4" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="pt-3 border-t flex justify-end space-x-2">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
