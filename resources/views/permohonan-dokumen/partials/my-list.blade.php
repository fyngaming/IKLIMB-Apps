<div class="space-y-3">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 space-y-0 responsive-grid-2">
    @forelse($myDokumens as $dok)
        <a href="{{ route('permohonan-dokumen.show', $dok->id) }}" class="block bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-500 hover:shadow-md transition space-y-2.5">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-mono text-[10px] text-slate-400 font-bold block">{{ $dok->nomor_permohonan }}</span>
                    <h3 class="font-bold text-sm text-slate-800">{{ $dok->jenis_dokumen }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-1">Keperluan: {{ $dok->keperluan }}</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                    {{ $dok->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}
                    {{ $dok->status === 'diajukan' ? 'bg-amber-100 text-amber-800' : '' }}
                    {{ $dok->status === 'diverifikasi' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $dok->status === 'diproses' ? 'bg-indigo-100 text-indigo-800' : '' }}
                    {{ $dok->status === 'siap_diambil' ? 'bg-purple-100 text-purple-800' : '' }}
                    {{ $dok->status === 'ditolak' ? 'bg-rose-100 text-rose-800' : '' }}">
                    {{ str_replace('_', ' ', $dok->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-2 p-2 bg-slate-50 rounded-xl text-xs">
                <div>
                    <span class="text-[10px] text-slate-400 block">Jumlah & Pengambilan:</span>
                    <span class="font-semibold text-slate-700">{{ $dok->jumlah_eksemplar }} Eks &bull; {{ $dok->metode_pengambilan }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 block">Tanggal Diajukan:</span>
                    <span class="font-semibold text-slate-700">{{ $dok->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>

            <div class="flex items-center space-x-1.5 text-[11px] font-bold text-emerald-700 pt-1">
                <span>Pelacakan Status & Timeline Berkas &rarr;</span>
            </div>
        </a>
    @empty
        <div class="col-span-2 bg-white p-6 rounded-2xl border border-slate-200 text-center text-slate-500 space-y-2">
            <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="font-bold text-sm text-slate-700">Belum Ada Permohonan Dokumen</h3>
            <p class="text-xs">Ajukan legalisir ijazah atau surat pengantar alumni untuk keperluan studi/karier.</p>
            <a href="{{ route('permohonan-dokumen.create') }}" class="inline-block mt-2 py-2 px-4 rounded-xl bg-emerald-700 text-white font-bold text-xs">
                + Ajukan Dokumen Baru
            </a>
        </div>
    @endforelse
    </div>

    {{ $myDokumens->links() }}
</div>
