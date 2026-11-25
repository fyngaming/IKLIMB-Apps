<div class="space-y-3">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 space-y-0 responsive-grid-2">
    @forelse($myKunjungans as $k)
        <a href="{{ route('kunjungan.show', $k->id) }}" class="block bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition space-y-2">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-mono text-[10px] text-slate-400 font-bold block">{{ $k->kode_kunjungan }}</span>
                    <h3 class="font-bold text-sm text-slate-800">{{ $k->tujuan }}</h3>
                    <p class="text-xs text-slate-500">Pihak ditemui: <span class="font-medium text-slate-700">{{ $k->pihak_ditemui }}</span></p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                    {{ $k->status === 'disetujui' ? 'bg-emerald-100 text-emerald-800' : '' }}
                    {{ $k->status === 'menunggu' ? 'bg-amber-100 text-amber-800' : '' }}
                    {{ $k->status === 'dijadwalkan_ulang' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $k->status === 'selesai' ? 'bg-slate-100 text-slate-800' : '' }}
                    {{ $k->status === 'ditolak' ? 'bg-rose-100 text-rose-800' : '' }}">
                    {{ $k->status }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-2 p-2 bg-slate-50 rounded-xl text-xs">
                <div>
                    <span class="text-[10px] text-slate-400 block">Tanggal Kunjungan:</span>
                    <span class="font-semibold text-slate-700">{{ $k->tanggal_kunjungan->format('d M Y') }} &bull; {{ substr($k->jam_kunjungan, 0, 5) }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 block">Rombongan:</span>
                    <span class="font-semibold text-slate-700">{{ $k->jumlah_rombongan }} Orang ({{ $k->is_menginap ? 'Menginap' : 'PP' }})</span>
                </div>
            </div>

            @if($k->status === 'disetujui')
                <div class="flex items-center space-x-1.5 text-[11px] font-bold text-emerald-700 pt-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    <span>Tiket QR Masuk Siap Digunakan &rarr;</span>
                </div>
            @endif
        </a>
    @empty
        <div class="col-span-2 bg-white p-6 rounded-2xl border border-slate-200 text-center text-slate-500 space-y-2">
            <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h3 class="font-bold text-sm text-slate-700">Belum Ada Kunjungan</h3>
            <p class="text-xs">Rencanakan silaturahmi Anda ke Pondok Pesantren PPIB sekarang.</p>
            <a href="{{ route('kunjungan.create') }}" class="inline-block mt-2 py-2 px-4 rounded-xl bg-emerald-700 text-white font-bold text-xs">
                + Buat Pengajuan Kunjungan
            </a>
        </div>
    @endforelse
    </div>

    {{ $myKunjungans->links() }}
</div>
