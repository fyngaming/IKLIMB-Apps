@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <!-- Breadcrumb & Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200">
        <div class="flex items-center space-x-2 text-xs">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-emerald-700 font-medium transition">Beranda</a>
            <span class="text-slate-400">/</span>
            <a href="{{ route('permohonan-dokumen.index') }}" class="text-slate-500 hover:text-emerald-700 font-medium transition">Dokumen TU</a>
            <span class="text-slate-400">/</span>
            <span class="font-bold text-emerald-900 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">{{ $dokumen->nomor_permohonan }}</span>
        </div>
        <a href="{{ route('permohonan-dokumen.index') }}" class="py-1.5 px-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold flex items-center space-x-1.5 transition shadow-sm w-fit">
            <span>&larr;</span>
            <span>Kembali ke Dokumen</span>
        </a>
    </div>

    <!-- Responsive Layout: 1 Column on Mobile, 2 Columns on Desktop -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 responsive-grid-2">
        
        <!-- Left Column: Overview & Visual Status Timeline -->
        <div class="lg:col-span-5 responsive-col-span-5 space-y-4">
            
            <!-- Status Overview Card -->
            <div class="bg-gradient-to-br from-emerald-900 to-emerald-800 text-white p-5 rounded-3xl shadow-lg relative overflow-hidden">
                <span class="text-[10px] uppercase font-bold text-gold-300 tracking-wider block">Layanan Dokumen Alumni</span>
                <h1 class="text-base font-extrabold text-white mt-0.5">{{ $dokumen->jenis_dokumen }}</h1>
                <p class="text-xs text-emerald-200 mt-1">Pemohon: <strong>{{ $dokumen->user->name }}</strong> (NIS: {{ $dokumen->user->alumniProfile->nis ?? '-' }})</p>

                <div class="mt-3 pt-3 border-t border-emerald-700/60 flex items-center justify-between">
                    <span class="text-xs text-emerald-200">Status Terkini:</span>
                    <span class="px-2.5 py-1 rounded-full bg-gold-400 text-slate-950 text-xs font-extrabold uppercase shadow">
                        {{ str_replace('_', ' ', $dokumen->status) }}
                    </span>
                </div>
            </div>

            <!-- 5-Step Visual Status Timeline Tracking -->
            @php
                $steps = [
                    'diajukan' => ['label' => 'Diajukan', 'desc' => 'Permohonan diterima sistem TU'],
                    'diverifikasi' => ['label' => 'Diverifikasi', 'desc' => 'Kelayakan berkas divalidasi'],
                    'diproses' => ['label' => 'Diproses', 'desc' => 'Penandatanganan & legalisir resmi'],
                    'siap_diambil' => ['label' => 'Siap Diambil/Kirim', 'desc' => 'Dokumen fisik/digital selesai'],
                    'selesai' => ['label' => 'Selesai', 'desc' => 'Dokumen telah diserahkan'],
                ];

                $stepKeys = array_keys($steps);
                $currentIndex = array_search($dokumen->status, $stepKeys);
                if ($currentIndex === false) $currentIndex = 0;
            @endphp

            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5 border-b pb-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <span>Pelacakan Status Realtime</span>
                </h2>

                <div class="relative pl-6 space-y-4 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    @foreach($steps as $key => $info)
                        @php
                            $stepIndex = array_search($key, $stepKeys);
                            $isDone = $stepIndex <= $currentIndex;
                            $isCurrent = $stepIndex === $currentIndex;
                        @endphp
                        <div class="relative">
                            <span class="absolute -left-6 top-0.5 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold {{ $isDone ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' : 'bg-slate-200 text-slate-500' }}">
                                @if($isDone)
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    {{ $stepIndex + 1 }}
                                @endif
                            </span>
                            <div>
                                <h3 class="text-xs font-bold {{ $isCurrent ? 'text-emerald-800' : ($isDone ? 'text-slate-800' : 'text-slate-400') }}">
                                    {{ $info['label'] }}
                                </h3>
                                <p class="text-[11px] {{ $isDone ? 'text-slate-500' : 'text-slate-400' }}">
                                    {{ $info['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Right Column: Rincian Permohonan & Staff TU Action -->
        <div class="lg:col-span-7 responsive-col-span-7 space-y-4">
            
            <!-- Details Card -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
                <h2 class="font-bold text-slate-800 uppercase tracking-wider text-xs border-b pb-2 flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Rincian Permohonan Dokumen</span>
                </h2>
                
                <div class="grid grid-cols-2 gap-3 pt-1">
                    <div>
                        <span class="text-slate-400 text-[10px] block">Jumlah Eksemplar</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $dokumen->jumlah_eksemplar }} Berkas</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] block">Metode Pengambilan</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $dokumen->metode_pengambilan }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 text-[10px] block">Keperluan Dokumen</span>
                        <p class="text-slate-700 leading-relaxed bg-slate-50 p-2.5 rounded-xl mt-0.5">{{ $dokumen->keperluan }}</p>
                    </div>
                    @if($dokumen->alamat_pengiriman)
                        <div class="col-span-2 p-3 bg-amber-50/70 border border-amber-200/70 rounded-xl">
                            <span class="text-amber-800 font-bold text-[10px] block uppercase">Alamat Ekspedisi / Kurir:</span>
                            <span class="text-xs text-amber-950 font-medium">{{ $dokumen->alamat_pengiriman }}</span>
                        </div>
                    @endif
                    @if($dokumen->catatan_admin)
                        <div class="col-span-2 p-3 bg-blue-50 border border-blue-200 rounded-xl text-blue-900">
                            <span class="font-bold block text-[11px]">Catatan dari Petugas TU:</span>
                            <span class="text-xs leading-relaxed">{{ $dokumen->catatan_admin }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Staff Action (Admin / Koordinator TU) -->
            @if(in_array(auth()->user()->role, ['admin', 'koordinator']))
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b pb-2 flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Perbarui Status Berkas (Admin TU)</span>
                    </h3>

                    <form action="{{ route('permohonan-dokumen.status', $dokumen->id) }}" method="POST" class="space-y-3 text-xs">
                        @csrf
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Status Pemrosesan</label>
                            <select name="status" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl font-bold">
                                <option value="diajukan" {{ $dokumen->status === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diverifikasi" {{ $dokumen->status === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="diproses" {{ $dokumen->status === 'diproses' ? 'selected' : '' }}>Diproses (Pencetakan / TTD)</option>
                                <option value="siap_diambil" {{ $dokumen->status === 'siap_diambil' ? 'selected' : '' }}>Siap Diambil / Dikirim</option>
                                <option value="selesai" {{ $dokumen->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $dokumen->status === 'ditolak' ? 'selected' : '' }}>Tolak Permohonan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Catatan Tambahan untuk Alumni</label>
                            <input type="text" name="catatan_admin" value="{{ $dokumen->catatan_admin }}" placeholder="Contoh: Dokumen telah siap diambil di Meja TU..."
                                class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                        </div>

                        <button type="submit" class="w-full py-2.5 px-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow transition">
                            Simpan Perubahan Status
                        </button>
                    </form>
                </div>
            @endif

            <!-- Layanan TU Info -->
            <div class="p-4 bg-slate-100 rounded-3xl text-xs text-slate-600 space-y-1">
                <span class="font-bold text-slate-800 block">Jam Operasional Tata Usaha:</span>
                <p class="text-[11px] leading-relaxed">Senin - Sabtu: 08.00 - 15.00 WIB. Pengambilan dokumen langsung di Ruang TU Gedung Utama Pondok Pesantren PPIB.</p>
            </div>

        </div>

    </div>

</div>
@endsection
