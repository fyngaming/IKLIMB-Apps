@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showCreateModal: false, showEditModal: false, selectedArticle: {} }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-4 border-slate-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700">&larr; Panel Admin</a>
                <span>/</span>
                <span class="font-bold text-slate-800">Manajemen Kabar Pondok</span>
            </div>
            <h1 class="text-xl font-black text-slate-900">Kelola Warta & Berita Pondok</h1>
            <p class="text-xs text-slate-500">Tulis artikel berita terkini, pengumuman, agenda resmi, serta hapus atau perbarui publikasi kabar.</p>
        </div>
        <button type="button" @click="showCreateModal = true" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 text-white font-bold text-xs shadow-md transition flex items-center space-x-2 self-start sm:self-auto">
            <span class="text-base font-bold">+</span>
            <span>Tulis Kabar Baru</span>
        </button>
    </div>

    <!-- Articles List Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b text-[10px]">
                    <tr>
                        <th class="p-4">Kabar / Berita</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Penulis</th>
                        <th class="p-4">Tanggal / Status</th>
                        <th class="p-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($articles as $art)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $art->gambar }}" alt="Cover" class="w-12 h-12 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                                    <div>
                                        <div class="flex items-center space-x-1.5">
                                            @if($art->is_pinned)
                                                <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 text-[9px] font-bold inline-flex items-center space-x-1">
                                                    <svg class="w-3 h-3 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                                    <span>Pinned</span>
                                                </span>
                                            @endif
                                            <a href="{{ route('kabar-pondok.show', $art->slug) }}" target="_blank" class="font-extrabold text-sm text-slate-900 hover:text-emerald-700 transition">
                                                {{ $art->judul }}
                                            </a>
                                        </div>
                                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $art->ringkasan }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 font-bold text-[10px]">{{ $art->kategori }}</span>
                            </td>
                            <td class="p-4 text-slate-700 font-semibold">
                                {{ $art->author->name ?? 'Admin Pondok' }}
                            </td>
                            <td class="p-4">
                                @if($art->published_at)
                                    <span class="text-emerald-700 font-bold block">Terbit</span>
                                    <span class="text-[10px] text-slate-400">{{ $art->published_at->format('d M Y') }}</span>
                                @else
                                    <span class="text-slate-400 font-bold block">Draft</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-1">
                                <button type="button" @click="selectedArticle = {
                                    id: {{ $art->id }},
                                    judul: '{{ addslashes($art->judul) }}',
                                    kategori: '{{ addslashes($art->kategori) }}',
                                    ringkasan: '{{ addslashes($art->ringkasan) }}',
                                    konten: '{{ addslashes($art->konten) }}',
                                    gambar: '{{ addslashes($art->gambar) }}',
                                    is_pinned: {{ $art->is_pinned ? 'true' : 'false' }},
                                    status: '{{ $art->published_at ? 'published' : 'draft' }}'
                                }; showEditModal = true" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                                    Edit
                                </button>
                                <form action="{{ route('admin.kabar.destroy', $art->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 rounded-xl text-rose-600 hover:bg-rose-50 font-bold transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-400">Belum ada kabar pondok yang diunggah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pt-2">
        {{ $articles->links() }}
    </div>

    <!-- MODAL 1: TULIS KABAR BARU -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100" @click.away="showCreateModal = false">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-black text-base text-slate-900">Tulis Kabar Pondok Baru</h3>
                <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <form action="{{ route('admin.kabar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs" x-data="{ uploadType: 'file', previewUrl: null }">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Kabar / Berita <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: Daurah Ilmiah Alumni Angkatan 1-15 Sukses Terselenggara" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                        <select name="kategori" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="Berita Pondok">Berita Pondok</option>
                            <option value="Pengumuman Resmi">Pengumuman Resmi</option>
                            <option value="Agenda Kegiatan">Agenda Kegiatan</option>
                            <option value="Prestasi Santri">Prestasi Santri</option>
                            <option value="Kisah Alumni">Kisah Alumni</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="published">Langsung Terbitkan (Published)</option>
                            <option value="draft">Simpan Sebagai Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ringkasan Singkat <span class="text-rose-500">*</span></label>
                    <textarea name="ringkasan" rows="2" required placeholder="Ringkasan 1-2 kalimat untuk preview di beranda..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Isi Lengkap Artikel <span class="text-rose-500">*</span></label>
                    <textarea name="konten" rows="5" required placeholder="Tuliskan berita lengkap di sini..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <!-- Gambar Sampul: Dual Option (Upload File / Input Link) -->
                <div class="space-y-2 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block font-bold text-slate-800">Gambar Sampul Berita</label>
                    <div class="flex items-center space-x-1.5 bg-white p-1 rounded-xl w-fit border border-slate-200 text-[11px] font-bold">
                        <button type="button" @click="uploadType = 'file'" :class="uploadType === 'file' ? 'bg-emerald-800 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1 rounded-lg transition flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Upload File Gambar</span>
                        </button>
                        <button type="button" @click="uploadType = 'url'" :class="uploadType === 'url' ? 'bg-emerald-800 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1 rounded-lg transition flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            <span>Input Link URL</span>
                        </button>
                    </div>

                    <!-- File Input -->
                    <div x-show="uploadType === 'file'" class="space-y-1">
                        <input type="file" name="gambar_file" accept="image/*" @change="if($event.target.files.length) { previewUrl = URL.createObjectURL($event.target.files[0]); }" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-900 hover:file:bg-emerald-200 bg-white border border-slate-300 rounded-xl cursor-pointer">
                        <p class="text-[10px] text-slate-400">Pilih foto dari komputer/HP (JPG, PNG, WEBP, maks 5MB).</p>
                    </div>

                    <!-- URL Input -->
                    <div x-show="uploadType === 'url'" class="space-y-1">
                        <input type="url" name="gambar_url" @input="previewUrl = $event.target.value" placeholder="https://..." class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                        <p class="text-[10px] text-slate-400">Tempelkan tautan langsung ke file gambar online.</p>
                    </div>

                    <!-- Real-time Preview -->
                    <template x-if="previewUrl">
                        <div class="mt-2 flex items-center space-x-3 p-2 bg-emerald-50 rounded-xl border border-emerald-200">
                            <img :src="previewUrl" alt="Preview" class="w-16 h-12 object-cover rounded-lg border border-slate-300 shadow-sm flex-shrink-0">
                            <span class="text-[11px] text-emerald-800 font-bold">Preview Gambar Siap Pakai</span>
                        </div>
                    </template>
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" name="is_pinned" id="is_pinned" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="is_pinned" class="font-semibold text-slate-700 text-xs">Sematkan sebagai Berita Utama (Pinned)</label>
                </div>

                <div class="pt-3 border-t flex justify-end space-x-2">
                    <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold shadow-md">Simpan Kabar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT KABAR -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100" @click.away="showEditModal = false">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-black text-base text-slate-900">Perbarui Kabar Pondok</h3>
                <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <form :action="'/admin/kabar-pondok/' + selectedArticle.id" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs" x-data="{ editUploadType: 'file', editPreviewUrl: null }">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Kabar <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" x-model="selectedArticle.judul" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                        <select name="kategori" x-model="selectedArticle.kategori" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="Berita Pondok">Berita Pondok</option>
                            <option value="Pengumuman Resmi">Pengumuman Resmi</option>
                            <option value="Agenda Kegiatan">Agenda Kegiatan</option>
                            <option value="Prestasi Santri">Prestasi Santri</option>
                            <option value="Kisah Alumni">Kisah Alumni</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select name="status" x-model="selectedArticle.status" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="published">Terbit (Published)</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ringkasan Singkat <span class="text-rose-500">*</span></label>
                    <textarea name="ringkasan" x-model="selectedArticle.ringkasan" rows="2" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Isi Lengkap Artikel <span class="text-rose-500">*</span></label>
                    <textarea name="konten" x-model="selectedArticle.konten" rows="5" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <!-- Gambar Sampul: Dual Option Edit -->
                <div class="space-y-2 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block font-bold text-slate-800">Ubah Gambar Sampul (Opsional)</label>
                    <div class="flex items-center space-x-1.5 bg-white p-1 rounded-xl w-fit border border-slate-200 text-[11px] font-bold">
                        <button type="button" @click="editUploadType = 'file'" :class="editUploadType === 'file' ? 'bg-emerald-800 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1 rounded-lg transition flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Upload File Baru</span>
                        </button>
                        <button type="button" @click="editUploadType = 'url'" :class="editUploadType === 'url' ? 'bg-emerald-800 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1 rounded-lg transition flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            <span>Input Link URL</span>
                        </button>
                    </div>

                    <!-- File Input -->
                    <div x-show="editUploadType === 'file'" class="space-y-1">
                        <input type="file" name="gambar_file" accept="image/*" @change="if($event.target.files.length) { editPreviewUrl = URL.createObjectURL($event.target.files[0]); }" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-900 hover:file:bg-emerald-200 bg-white border border-slate-300 rounded-xl cursor-pointer">
                        <p class="text-[10px] text-slate-400">Pilih file gambar pengganti (biarkan kosong jika tetap menggunakan gambar saat ini).</p>
                    </div>

                    <!-- URL Input -->
                    <div x-show="editUploadType === 'url'" class="space-y-1">
                        <input type="url" name="gambar_url" x-model="selectedArticle.gambar" @input="editPreviewUrl = $event.target.value" placeholder="https://..." class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <!-- Preview Current or New Image -->
                    <div class="mt-2 flex items-center space-x-3 p-2 bg-slate-100 rounded-xl border border-slate-200">
                        <img :src="editPreviewUrl || selectedArticle.gambar" alt="Preview" class="w-16 h-12 object-cover rounded-lg border border-slate-300 shadow-sm flex-shrink-0">
                        <div>
                            <span class="text-[11px] font-bold text-slate-700 block" x-text="editPreviewUrl ? 'Gambar Baru Terpilih' : 'Gambar Saat Ini'"></span>
                            <span class="text-[10px] text-slate-400">Akan ditampilkan pada artikel</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" name="is_pinned" id="is_pinned_edit" x-model="selectedArticle.is_pinned" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="is_pinned_edit" class="font-semibold text-slate-700 text-xs">Sematkan sebagai Berita Utama (Pinned)</label>
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
