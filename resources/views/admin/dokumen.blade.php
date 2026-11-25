@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ showStatusModal: false, selectedDoc: {} }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-4 border-slate-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700">&larr; Panel Admin</a>
                <span>/</span>
                <span class="font-bold text-slate-800">Manajemen Dokumen TU</span>
            </div>
            <h1 class="text-xl font-black text-slate-900">Pelayanan Dokumen Tata Usaha (TU)</h1>
            <p class="text-xs text-slate-500">Kelola dan perbarui status permohonan legalisasi ijazah, surat keterangan alumni, dan surat rekomendasi studi.</p>
        </div>
    </div>

    <!-- Status Filters -->
    <div class="flex items-center space-x-2 overflow-x-auto pb-1 text-xs font-bold">
        <a href="{{ route('admin.dokumen.index') }}" class="px-3.5 py-1.5 rounded-xl transition {{ empty($status) ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Semua Permohonan
        </a>
        <a href="{{ route('admin.dokumen.index', ['status' => 'diajukan']) }}" class="px-3.5 py-1.5 rounded-xl transition {{ $status === 'diajukan' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Diajukan
        </a>
        <a href="{{ route('admin.dokumen.index', ['status' => 'diverifikasi']) }}" class="px-3.5 py-1.5 rounded-xl transition {{ $status === 'diverifikasi' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Diverifikasi
        </a>
        <a href="{{ route('admin.dokumen.index', ['status' => 'diproses']) }}" class="px-3.5 py-1.5 rounded-xl transition {{ $status === 'diproses' ? 'bg-purple-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Diproses TU
        </a>
        <a href="{{ route('admin.dokumen.index', ['status' => 'siap_diambil']) }}" class="px-3.5 py-1.5 rounded-xl transition {{ $status === 'siap_diambil' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Siap Diambil
        </a>
        <a href="{{ route('admin.dokumen.index', ['status' => 'selesai']) }}" class="px-3.5 py-1.5 rounded-xl transition {{ $status === 'selesai' ? 'bg-slate-800 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Selesai
        </a>
    </div>

    <!-- Documents List Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b text-[10px]">
                    <tr>
                        <th class="p-4">No. Permohonan</th>
                        <th class="p-4">Jenis Dokumen</th>
                        <th class="p-4">Pemohon (Alumni)</th>
                        <th class="p-4">Metode Pengambilan</th>
                        <th class="p-4">Status Saat Ini</th>
                        <th class="p-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-mono font-bold text-slate-800">
                                #{{ $doc->nomor_permohonan }}
                                <span class="block text-[10px] text-slate-400 font-sans font-normal">{{ $doc->created_at->format('d M Y H:i') }}</span>
                            </td>
                            <td class="p-4">
                                <span class="font-extrabold text-slate-900 block">{{ $doc->jenis_dokumen }}</span>
                                <span class="text-[11px] text-slate-500">Jumlah: {{ $doc->jumlah_eksemplar }} Eks &bull; Untuk: {{ $doc->keperluan }}</span>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-slate-800 block">{{ $doc->user->name }}</span>
                                <span class="text-[11px] text-slate-500 font-mono">{{ $doc->user->no_wa }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $doc->metode_pengambilan === 'ambil_langsung' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                    {{ $doc->metode_pengambilan === 'ambil_langsung' ? 'Ambil di Pos TU' : 'Kirim Ekspedisi' }}
                                </span>
                            </td>
                            <td class="p-4">
                                @php
                                    $badge = match($doc->status) {
                                        'diajukan' => 'bg-amber-100 text-amber-800',
                                        'diverifikasi' => 'bg-blue-100 text-blue-800',
                                        'diproses' => 'bg-purple-100 text-purple-800',
                                        'siap_diambil' => 'bg-emerald-100 text-emerald-800',
                                        'selesai' => 'bg-slate-100 text-slate-800',
                                        default => 'bg-rose-100 text-rose-800',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $badge }}">
                                    {{ str_replace('_', ' ', $doc->status) }}
                                </span>
                                @if($doc->catatan_admin)
                                    <p class="text-[10px] text-slate-400 mt-0.5 max-w-[180px] truncate">Catatan: {{ $doc->catatan_admin }}</p>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <button type="button" @click="selectedDoc = {
                                    id: {{ $doc->id }},
                                    nomor: '{{ $doc->nomor_permohonan }}',
                                    pemohon: '{{ addslashes($doc->user->name) }}',
                                    jenis: '{{ addslashes($doc->jenis_dokumen) }}',
                                    status: '{{ $doc->status }}',
                                    catatan: '{{ addslashes($doc->catatan_admin ?? '') }}'
                                }; showStatusModal = true" class="px-3 py-1.5 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold transition shadow-sm">
                                    Update Status
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-400">Tidak ada data permohonan dokumen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pt-2">
        {{ $documents->links() }}
    </div>

    <!-- MODAL UPDATE STATUS DOKUMEN -->
    <div x-show="showStatusModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100" @click.away="showStatusModal = false">
            <div class="flex items-center justify-between border-b pb-3">
                <div>
                    <h3 class="font-black text-base text-slate-900">Perbarui Status Dokumen TU</h3>
                    <p class="text-[11px] text-slate-500" x-text="'No. Permohonan: #' + selectedDoc.nomor + ' (' + selectedDoc.pemohon + ')'"></p>
                </div>
                <button type="button" @click="showStatusModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
            </div>

            <form :action="'/admin/dokumen-tu/' + selectedDoc.id + '/status'" method="POST" class="space-y-3.5 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Dokumen <span class="text-rose-500">*</span></label>
                    <select name="status" x-model="selectedDoc.status" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 font-bold">
                        <option value="diajukan">1. Diajukan (Menunggu Konfirmasi TU)</option>
                        <option value="diverifikasi">2. Diverifikasi (Berkas Lengkap & Sah)</option>
                        <option value="diproses">3. Diproses (Pencetakan / Tanda Tangan Mudir)</option>
                        <option value="siap_diambil">4. Siap Diambil / Siap Kirim</option>
                        <option value="selesai">5. Selesai (Dokumen Telah Diterima Alumni)</option>
                        <option value="ditolak">Ditolak (Berkas Tidak Sesuai)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan Tambahan untuk Pemohon</label>
                    <textarea name="catatan_admin" x-model="selectedDoc.catatan" rows="3" placeholder="Contoh: Dokumen sudah dilegalisir, silakan diambil di Pos TU Pesantren PPIB pukul 08:00 - 15:00 WIB..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="pt-3 border-t flex justify-end space-x-2">
                    <button type="button" @click="showStatusModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
