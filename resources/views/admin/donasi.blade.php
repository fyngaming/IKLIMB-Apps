@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showCreateModal: false, showEditModal: false, selectedProgram: {} }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-4 border-slate-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700">&larr; Panel Admin</a>
                <span>/</span>
                <span class="font-bold text-slate-800">Manajemen Donasi & Wakaf</span>
            </div>
            <h1 class="text-xl font-black text-slate-900">Kelola Program Donasi & Wakaf PPIB</h1>
            <p class="text-xs text-slate-500">Buka penggalangan dana baru untuk berbagai keperluan pondok, pantau capaian dana, dan kelola status.</p>
        </div>
        <button type="button" @click="showCreateModal = true" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-gold-400 to-amber-400 hover:from-gold-500 text-slate-950 font-extrabold text-xs shadow-md transition flex items-center space-x-2 self-start sm:self-auto">
            <span class="text-base font-bold">+</span>
            <span>Buka Program Donasi Baru</span>
        </button>
    </div>

    <!-- Programs Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 responsive-grid-2">
        @foreach($programs as $prog)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                <div class="space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ $prog->is_aktif ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $prog->is_aktif ? 'Aktif' : 'Selesai / Ditutup' }}
                        </span>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">{{ $prog->kategori }}</span>
                    </div>

                    <div>
                        <h3 class="font-extrabold text-base text-slate-900 leading-snug">{{ $prog->judul }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $prog->deskripsi }}</p>
                    </div>

                    <!-- Progress Bar -->
                    <div class="space-y-1.5 pt-1">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-emerald-800 font-bold">Rp {{ number_format($prog->dana_terkumpul, 0, ',', '.') }}</span>
                            <span class="text-slate-400 text-[11px]">Target: Rp {{ number_format($prog->target_dana, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-emerald-600 h-full rounded-full" style="width: {{ $prog->progress_percentage }}%;"></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-slate-400">
                            <span>Tercapai {{ $prog->progress_percentage }}%</span>
                            <span>Batas: {{ $prog->tanggal_berakhir ? $prog->tanggal_berakhir->format('d M Y') : 'Terbuka' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-[11px] text-slate-400">{{ $prog->transaksis_count ?? 0 }} Donatur</span>
                    <div class="flex items-center space-x-1.5">
                        <button type="button" @click="selectedProgram = {
                            id: {{ $prog->id }},
                            judul: '{{ addslashes($prog->judul) }}',
                            kategori: '{{ addslashes($prog->kategori) }}',
                            target_dana: {{ $prog->target_dana }},
                            dana_terkumpul: {{ $prog->dana_terkumpul }},
                            tanggal_berakhir: '{{ $prog->tanggal_berakhir ? $prog->tanggal_berakhir->format('Y-m-d') : '' }}',
                            deskripsi: '{{ addslashes($prog->deskripsi) }}',
                            gambar: '{{ addslashes($prog->gambar) }}',
                            is_aktif: {{ $prog->is_aktif ? 'true' : 'false' }}
                        }; showEditModal = true" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                            Edit
                        </button>
                        <form action="{{ route('admin.donasi.destroy', $prog->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program donasi ini?')">
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
        {{ $programs->links() }}
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
        <h2 class="text-sm font-extrabold text-slate-900">Riwayat Transaksi Donasi Masuk</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b text-[10px]">
                    <tr>
                        <th class="p-3">Kode / Waktu</th>
                        <th class="p-3">Program Donasi</th>
                        <th class="p-3">Donatur</th>
                        <th class="p-3">Nominal</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono font-semibold">{{ $trx->kode_transaksi }}<br><span class="text-[10px] text-slate-400 font-sans">{{ $trx->created_at->format('d M Y H:i') }}</span></td>
                            <td class="p-3 font-medium">{{ $trx->program->judul }}</td>
                            <td class="p-3">{{ $trx->is_anonim ? 'Hamba Allah (Anonim)' : ($trx->user->name ?? $trx->nama_donatur) }}</td>
                            <td class="p-3 font-bold text-emerald-800">Rp {{ number_format($trx->nominal, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $trx->status_pembayaran === 'berhasil' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $trx->status_pembayaran }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-slate-400">Belum ada catatan transaksi donasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: BUKA PROGRAM DONASI BARU -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100" @click.away="showCreateModal = false">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-black text-base text-slate-900">Buka Program Donasi / Wakaf Baru</h3>
                <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <form action="{{ route('admin.donasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs" x-data="{ uploadType: 'file', previewUrl: null }">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Program / Keperluan <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: Wakaf Pembebasan Lahan Pesantren" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori / Sektor <span class="text-rose-500">*</span></label>
                        <select name="kategori" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="Wakaf Pembangunan">Wakaf Pembangunan</option>
                            <option value="Beasiswa Santri">Beasiswa Santri</option>
                            <option value="Sarana & Fasilitas">Sarana & Fasilitas</option>
                            <option value="Sosial & Dakwah">Sosial & Dakwah</option>
                            <option value="Tanggap Bencana">Tanggap Bencana</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Target Dana (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" name="target_dana" required min="100000" placeholder="50000000" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Batas Waktu Penggalangan (Opsional)</label>
                    <input type="date" name="tanggal_berakhir" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi Lengkap Keperluan <span class="text-rose-500">*</span></label>
                    <textarea name="deskripsi" rows="3" required placeholder="Jelaskan tujuan program, rincian penggunaan anggaran, serta manfaat bagi santri dan pondok..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <!-- Banner Donasi: Dual Option (Upload File / Input Link) -->
                <div class="space-y-2 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block font-bold text-slate-800">Banner / Gambar Program</label>
                    <div class="flex items-center space-x-1.5 bg-white p-1 rounded-xl w-fit border border-slate-200 text-[11px] font-bold">
                        <button type="button" @click="uploadType = 'file'" :class="uploadType === 'file' ? 'bg-emerald-800 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1 rounded-lg transition flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Upload File Banner</span>
                        </button>
                        <button type="button" @click="uploadType = 'url'" :class="uploadType === 'url' ? 'bg-emerald-800 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800'" class="px-3 py-1 rounded-lg transition flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            <span>Input Link URL</span>
                        </button>
                    </div>

                    <!-- File Input -->
                    <div x-show="uploadType === 'file'" class="space-y-1">
                        <input type="file" name="gambar_file" accept="image/*" @change="if($event.target.files.length) { previewUrl = URL.createObjectURL($event.target.files[0]); }" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-900 hover:file:bg-emerald-200 bg-white border border-slate-300 rounded-xl cursor-pointer">
                        <p class="text-[10px] text-slate-400">Pilih foto poster/banner (JPG, PNG, WEBP, maks 5MB).</p>
                    </div>

                    <!-- URL Input -->
                    <div x-show="uploadType === 'url'" class="space-y-1">
                        <input type="url" name="gambar_url" @input="previewUrl = $event.target.value" placeholder="https://..." class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                        <p class="text-[10px] text-slate-400">Tempelkan tautan langsung ke poster online.</p>
                    </div>

                    <!-- Preview -->
                    <template x-if="previewUrl">
                        <div class="mt-2 flex items-center space-x-3 p-2 bg-emerald-50 rounded-xl border border-emerald-200">
                            <img :src="previewUrl" alt="Preview" class="w-16 h-12 object-cover rounded-lg border border-slate-300 shadow-sm flex-shrink-0">
                            <span class="text-[11px] text-emerald-800 font-bold">Preview Banner Siap Pakai</span>
                        </div>
                    </template>
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" name="is_aktif" id="is_aktif" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="is_aktif" class="font-semibold text-slate-700 text-xs">Langsung aktifkan program agar dapat menerima donasi</label>
                </div>

                <div class="pt-3 border-t flex justify-end space-x-2">
                    <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold shadow-md">Simpan & Publikasikan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT PROGRAM DONASI -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100" @click.away="showEditModal = false">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 class="font-black text-base text-slate-900">Perbarui Program Donasi</h3>
                <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <form :action="'/admin/donasi-wakaf/' + selectedProgram.id" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs" x-data="{ editUploadType: 'file', editPreviewUrl: null }">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Program <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" x-model="selectedProgram.judul" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                        <select name="kategori" x-model="selectedProgram.kategori" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                            <option value="Wakaf Pembangunan">Wakaf Pembangunan</option>
                            <option value="Beasiswa Santri">Beasiswa Santri</option>
                            <option value="Sarana & Fasilitas">Sarana & Fasilitas</option>
                            <option value="Sosial & Dakwah">Sosial & Dakwah</option>
                            <option value="Tanggap Bencana">Tanggap Bencana</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Target Dana (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" name="target_dana" x-model="selectedProgram.target_dana" required min="100000" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Dana Terkumpul (Rp)</label>
                        <input type="number" name="dana_terkumpul" x-model="selectedProgram.dana_terkumpul" min="0" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Batas Waktu</label>
                        <input type="date" name="tanggal_berakhir" x-model="selectedProgram.tanggal_berakhir" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi <span class="text-rose-500">*</span></label>
                    <textarea name="deskripsi" x-model="selectedProgram.deskripsi" rows="3" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <!-- Banner Donasi: Dual Option Edit -->
                <div class="space-y-2 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block font-bold text-slate-800">Ubah Banner / Poster (Opsional)</label>
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
                        <p class="text-[10px] text-slate-400">Pilih file gambar poster pengganti (biarkan kosong jika tetap menggunakan gambar saat ini).</p>
                    </div>

                    <!-- URL Input -->
                    <div x-show="editUploadType === 'url'" class="space-y-1">
                        <input type="url" name="gambar_url" x-model="selectedProgram.gambar" @input="editPreviewUrl = $event.target.value" placeholder="https://..." class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <!-- Preview Current or New Image -->
                    <div class="mt-2 flex items-center space-x-3 p-2 bg-slate-100 rounded-xl border border-slate-200">
                        <img :src="editPreviewUrl || selectedProgram.gambar" alt="Preview" class="w-16 h-12 object-cover rounded-lg border border-slate-300 shadow-sm flex-shrink-0">
                        <div>
                            <span class="text-[11px] font-bold text-slate-700 block" x-text="editPreviewUrl ? 'Banner Baru Terpilih' : 'Banner Saat Ini'"></span>
                            <span class="text-[10px] text-slate-400">Akan ditampilkan pada halaman program</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Program</label>
                    <select name="is_aktif" x-model="selectedProgram.is_aktif" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                        <option :value="true">Aktif (Menerima Donasi)</option>
                        <option :value="false">Selesai / Ditutup</option>
                    </select>
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
