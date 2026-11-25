@extends('layouts.app')

@section('content')
<div class="space-y-5">

    <!-- Breadcrumb & Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200">
        <div class="flex items-center space-x-2 text-xs">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-emerald-700 font-medium transition">Beranda</a>
            <span class="text-slate-400">/</span>
            <a href="{{ route('kunjungan.index') }}" class="text-slate-500 hover:text-emerald-700 font-medium transition">Kunjungan</a>
            <span class="text-slate-400">/</span>
            <span class="font-bold text-emerald-900 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">{{ $kunjungan->kode_kunjungan }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('kunjungan.index') }}" class="py-1.5 px-3.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold flex items-center space-x-1.5 transition shadow-sm">
                <span>&larr;</span>
                <span>Daftar Kunjungan</span>
            </a>
            <button onclick="window.print()" class="py-1.5 px-3.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold flex items-center space-x-1.5 transition shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Tiket QR</span>
            </button>
        </div>
    </div>

    <!-- Responsive Grid: 1 Column on Mobile, 2 Columns on Desktop -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 responsive-grid-2">
        
        <!-- Left Column: Official Visit Ticket Card with QR Code -->
        <div class="lg:col-span-5 responsive-col-span-5">
            <div class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-950 text-white rounded-3xl p-6 shadow-2xl border-2 border-gold-400/80 relative overflow-hidden">
                
                <!-- Background Glow -->
                <div class="absolute -right-12 -top-12 w-44 h-44 rounded-full bg-gold-400/10 blur-2xl pointer-events-none"></div>

                <div class="flex items-center justify-between pb-3.5 border-b border-gold-400/30 relative z-10">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-10 h-10 rounded-xl bg-white p-1 border border-gold-400/80 flex items-center justify-center shadow-md">
                            <img src="/images/logo-ppib.png" alt="Logo PPIB" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="text-[9px] uppercase font-bold text-gold-300 tracking-widest block">Tiket Resmi Masuk Gerbang</span>
                            <h2 class="text-sm sm:text-base font-black text-white tracking-wide">Pondok Pesantren PPIB</h2>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm
                        {{ $kunjungan->status === 'disetujui' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/40' : '' }}
                        {{ $kunjungan->status === 'menunggu' ? 'bg-amber-500/20 text-amber-300 border border-amber-400/40' : '' }}
                        {{ $kunjungan->status === 'dijadwalkan_ulang' ? 'bg-blue-500/20 text-blue-300 border border-blue-400/40' : '' }}
                        {{ $kunjungan->status === 'selesai' ? 'bg-slate-500/20 text-slate-300 border border-slate-400/40' : '' }}">
                        {{ $kunjungan->status }}
                    </span>
                </div>

                <!-- Visit QR Code -->
                <div class="my-5 flex flex-col items-center justify-center relative z-10">
                    <div class="p-3.5 bg-white rounded-2xl shadow-2xl border-4 border-gold-400/90">
                        <div class="w-48 h-48 sm:w-52 sm:h-52 flex items-center justify-center">
                            {!! $qrSvg !!}
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <span class="text-[10px] text-emerald-300 font-mono tracking-widest block uppercase">KODE TIKET GERBANG POS</span>
                        <span class="font-mono text-sm font-black text-gold-300 tracking-wider">{{ $kunjungan->qr_visit_token }}</span>
                    </div>
                    @if($kunjungan->checked_in_at)
                        <div class="mt-2.5 px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-400/50 rounded-full text-xs font-bold flex items-center space-x-1.5 shadow">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>SUDAH CHECK-IN POS SATPAM</span>
                            <span>({{ $kunjungan->checked_in_at->format('d M H:i') }} WIB)</span>
                        </div>
                    @endif
                </div>

                <!-- Quick Visit Badges -->
                <div class="pt-4 border-t border-gold-400/30 text-xs space-y-2 relative z-10">
                    <div class="flex justify-between items-center">
                        <span class="text-emerald-300 text-[11px]">Nama Alumni:</span>
                        <span class="font-bold text-white text-sm">{{ $kunjungan->user->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-emerald-300 text-[11px]">NIS:</span>
                        <span class="font-mono text-gold-300 font-bold">{{ $kunjungan->user->alumniProfile->nis ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-emerald-300 text-[11px]">Waktu Kunjungan:</span>
                        <span class="font-semibold text-white">{{ $kunjungan->tanggal_kunjungan->format('d M Y') }} &bull; {{ substr($kunjungan->jam_kunjungan, 0, 5) }} WIB</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-emerald-300 text-[11px]">Menginap:</span>
                        <span class="font-bold {{ $kunjungan->is_menginap ? 'text-amber-300' : 'text-slate-300' }}">
                            {{ $kunjungan->is_menginap ? 'Ya (Wisma Tamu Pondok)' : 'Tidak (Pulang Pergi)' }}
                        </span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-emerald-800/80 text-[10px] text-emerald-300 text-center flex justify-between">
                    <span>Pos Satpam Pondok Pesantren PPIB</span>
                    <span>Tahun {{ date('Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Petugas Notes & Staff Action & Details -->
        <div class="lg:col-span-7 responsive-col-span-7 space-y-4">
            
            <!-- Rescheduling / Petugas Notes Alert -->
            @if($kunjungan->catatan_petugas)
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl text-xs space-y-2 shadow-sm">
                    <div class="font-bold text-blue-900 flex items-center space-x-1.5 text-sm">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Catatan dari Pengurus / Koordinator:</span>
                    </div>
                    <p class="text-blue-800 leading-relaxed text-xs">{{ $kunjungan->catatan_petugas }}</p>
                    @if($kunjungan->jadwal_ulang_tanggal)
                        <div class="text-blue-950 font-bold pt-2 border-t border-blue-200/60 flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Jadwal Baru yang Disarankan:</span>
                            <span class="px-2 py-0.5 rounded bg-blue-200/70 text-blue-900 font-mono">{{ $kunjungan->jadwal_ulang_tanggal->format('d M Y') }} &bull; {{ substr($kunjungan->jadwal_ulang_jam, 0, 5) }} WIB</span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Full Visit Details Card -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
                <h3 class="font-extrabold text-slate-800 uppercase tracking-wider text-xs border-b pb-2 flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Rincian Pengajuan Kunjungan</span>
                </h3>

                <div class="grid grid-cols-2 gap-3 pt-1">
                    <div>
                        <span class="text-slate-400 text-[10px] block">Tujuan Kunjungan</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $kunjungan->tujuan }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] block">Pihak yang Ingin Ditemui</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $kunjungan->pihak_ditemui }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] block">Jumlah Rombongan</span>
                        <span class="font-bold text-slate-800">{{ $kunjungan->jumlah_rombongan }} Orang</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] block">Kendaraan</span>
                        <span class="font-bold text-slate-800">{{ $kunjungan->kendaraan ?? 'Kendaraan Pribadi' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 text-[10px] block">Nomor Kontak Alumni</span>
                        <span class="font-mono font-bold text-emerald-800 text-xs">{{ $kunjungan->user->no_wa }}</span>
                    </div>
                </div>
            </div>

            <!-- Staff Control Form (If Koordinator / Admin) -->
            @if(in_array(auth()->user()->role, ['admin', 'koordinator']))
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3" x-data="{ status: '{{ $kunjungan->status }}' }">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5 border-b pb-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>Kelola Status Kunjungan (Koordinator/Admin)</span>
                    </h3>

                    <form action="{{ route('kunjungan.status', $kunjungan->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Status Pengajuan</label>
                            <select name="status" x-model="status" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl font-bold">
                                <option value="disetujui">Setujui Kunjungan</option>
                                <option value="dijadwalkan_ulang">Jadwalkan Ulang</option>
                                <option value="selesai">Selesai (Sudah Berkunjung)</option>
                                <option value="ditolak">Tolak Kunjungan</option>
                            </select>
                        </div>

                        <div x-show="status === 'dijadwalkan_ulang'" class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Tanggal Baru</label>
                                <input type="date" name="jadwal_ulang_tanggal" value="{{ optional($kunjungan->jadwal_ulang_tanggal)->format('Y-m-d') }}" class="w-full px-2 py-1.5 text-xs bg-slate-50 border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Jam Baru</label>
                                <input type="time" name="jadwal_ulang_jam" value="{{ $kunjungan->jadwal_ulang_jam ?? '09:00' }}" class="w-full px-2 py-1.5 text-xs bg-slate-50 border rounded-lg">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Petugas untuk Alumni</label>
                            <textarea name="catatan_petugas" rows="2" placeholder="Tulis instruksi atau alasan reschedule..."
                                class="w-full px-3 py-1.5 text-xs bg-slate-50 border border-slate-300 rounded-xl">{{ $kunjungan->catatan_petugas }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 px-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow transition">
                            Perbarui Status Kunjungan
                        </button>
                    </form>
                </div>
            @endif

            <!-- Panduan Kunjungan Pondok -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-2.5 text-xs">
                <h3 class="font-bold text-slate-800 uppercase tracking-wider text-[11px] border-b pb-2 flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Panduan & Adab Kunjungan PPIB</span>
                </h3>
                <ul class="space-y-1.5 text-slate-600 text-[11px] list-disc list-inside leading-relaxed">
                    <li>Tunjukkan Kode QR Tiket ini kepada petugas pos keamanan satpam gerbang utama pondok saat tiba.</li>
                    <li>Berpakaian sopan, rapi, dan menutup aurat sesuai dengan adab dan tata tertib pesantren.</li>
                    <li>Waktu bertamu santri disarankan antara jam 09.00 - 17.00 WIB guna menjaga jadwal kedisiplinan belajar santri.</li>
                    <li>Bagi rombongan yang menginap, konfirmasi ke koordinator wisma tamu pondok setibanya di lokasi.</li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection
