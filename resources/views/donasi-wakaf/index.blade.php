@extends('layouts.app')

@section('content')
<div class="space-y-5" x-data="{ selectedProgram: null, showModal: false }">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-emerald-900 text-white p-5 rounded-3xl shadow-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-[10px] font-bold text-gold-300 uppercase tracking-wider block">Amal Jariyah & Wakaf Alumni</span>
            <h1 class="text-base font-extrabold text-white mt-0.5">Donasi & Wakaf PPIB</h1>
            <p class="text-xs text-emerald-200 mt-1 leading-relaxed">
                Salurkan infak, wakaf pembangunan, dan beasiswa santri berprestasi secara transparan.
            </p>
        </div>
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.donasi.index') }}" class="px-3.5 py-2 rounded-2xl bg-gold-400 hover:bg-gold-500 text-slate-950 font-black text-xs shadow-md transition flex items-center space-x-1.5 self-start sm:self-auto flex-shrink-0">
                <span>+ Buka Donasi Baru (Admin)</span>
            </a>
        @endif
    </div>

    <!-- Programs List (Responsive Grid: 1 col on mobile, 2 col on md/lg) -->
    <div class="space-y-3">
        <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Program Penggalangan Dana Aktif</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 space-y-0 responsive-grid-2">
        @foreach($programs as $prog)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden space-y-3 p-5 flex flex-col justify-between hover:shadow-md transition">
                <div class="space-y-2.5">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold uppercase">{{ $prog->kategori }}</span>
                            <h3 class="font-extrabold text-sm text-slate-900 mt-1.5">{{ $prog->judul }}</h3>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed">{{ $prog->deskripsi }}</p>
                </div>

                <div class="space-y-3 pt-2">
                    <!-- Progress Bar -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-emerald-800 font-bold">Rp {{ number_format($prog->dana_terkumpul, 0, ',', '.') }}</span>
                            <span class="text-slate-400">Target: Rp {{ number_format($prog->target_dana, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-emerald-600 h-full rounded-full transition-all duration-500" x-bind:style="{ width: '{{ $prog->progress_percentage }}%' }"></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-slate-500 pt-0.5">
                            <span>Tercapai {{ $prog->progress_percentage }}%</span>
                            <span>Berakhir: {{ $prog->tanggal_berakhir ? $prog->tanggal_berakhir->format('d M Y') : 'Terbuka' }}</span>
                        </div>
                    </div>

                    <button type="button" @click="selectedProgram = {{ $prog->id }}; showModal = true" class="w-full py-2.5 px-3 bg-gradient-to-r from-gold-400 to-amber-400 hover:from-gold-500 text-slate-950 font-bold text-xs rounded-xl shadow transition flex items-center justify-center space-x-1.5">
                        <svg class="w-4 h-4 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span>Donasi Sekarang</span>
                    </button>
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <!-- Penyaluran Dana Report -->
    @if($penyalurans->isNotEmpty())
        <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b pb-2">Laporan Penyaluran Dana Transparan</h2>
            <div class="space-y-2 text-xs">
                @foreach($penyalurans as $p)
                    <div class="p-2.5 bg-slate-50 rounded-xl space-y-1">
                        <div class="flex justify-between font-bold text-slate-800">
                            <span>{{ $p->judul_penyaluran }}</span>
                            <span class="text-emerald-700">Rp {{ number_format($p->nominal_disalurkan, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-[11px] text-slate-500">{{ $p->laporan_kegiatan }}</p>
                        <span class="text-[9px] text-slate-400 block">{{ $p->tanggal_penyaluran->format('d M Y') }} &bull; Program: {{ $p->program->judul }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Donasi Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-5 space-y-4 shadow-2xl" @click.away="showModal = false">
            <div class="flex items-center justify-between border-b pb-2">
                <h3 class="font-bold text-sm text-slate-800">Form Konfirmasi Donasi</h3>
                <button @click="showModal = false" class="text-slate-400 text-lg font-bold">&times;</button>
            </div>

            <form :action="'/donasi-wakaf/' + selectedProgram + '/transaksi'" method="POST" class="space-y-3 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nama Donatur / Hamba Allah</label>
                    <input type="text" name="nama_donatur" value="{{ auth()->user()->name }}" required
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nominal Donasi (Rp)</label>
                    <input type="number" name="nominal" min="10000" step="5000" placeholder="Contoh: 100000" required
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl font-bold text-emerald-800">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Doa / Harapan</label>
                    <textarea name="doa_harapan" rows="2" placeholder="Semoga berkah untuk pondok dan santri..."
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl"></textarea>
                </div>

                <div>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_anonim" value="1" class="w-4 h-4 text-emerald-600 rounded">
                        <span>Sembunyikan nama (Sebagai Hamba Allah)</span>
                    </label>
                </div>

                <div class="p-2.5 bg-emerald-50 rounded-xl text-emerald-900 text-[11px] leading-relaxed">
                    Rekening Resmi PPIB: <strong>BSI 7123-456-789 a.n. YAYASAN PPIB IKLIMB</strong>
                </div>

                <button type="submit" class="w-full py-2.5 px-3 bg-emerald-800 text-white font-bold text-xs rounded-xl shadow">
                    Konfirmasi Donasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
