@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Permohonan Dokumen</h1>
            <p class="text-xs text-slate-500">Legalisasi ijazah, surat alumni, & rekomendasi.</p>
        </div>
        <a href="{{ route('permohonan-dokumen.create') }}" class="py-2 px-3 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 text-white font-bold text-xs shadow flex items-center space-x-1">
            <span class="text-sm">+</span>
            <span>Ajukan Baru</span>
        </a>
    </div>

    @if($isStaff && $staffDokumens)
        <div x-data="{ tab: 'staff' }" class="space-y-3">
            <div class="flex bg-slate-200/80 p-1 rounded-xl text-xs font-bold">
                <button @click="tab = 'staff'" :class="tab === 'staff' ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600'" class="flex-1 py-1.5 rounded-lg transition text-center flex items-center justify-center space-x-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Kelola Dokumen TU ({{ $staffDokumens->total() }})</span>
                </button>
                <button @click="tab = 'my'" :class="tab === 'my' ? 'bg-white text-emerald-800 shadow-sm' : 'text-slate-600'" class="flex-1 py-1.5 rounded-lg transition text-center">
                    Permohonan Saya ({{ $myDokumens->total() }})
                </button>
            </div>

            <!-- Staff List -->
            <div x-show="tab === 'staff'" class="space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 space-y-0 responsive-grid-2">
                @forelse($staffDokumens as $dok)
                    <a href="{{ route('permohonan-dokumen.show', $dok->id) }}" class="block bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-500 transition space-y-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="font-mono text-[10px] text-slate-400 font-bold block">{{ $dok->nomor_permohonan }}</span>
                                <h3 class="font-bold text-sm text-slate-800">{{ $dok->jenis_dokumen }}</h3>
                                <p class="text-xs text-slate-500">Pemohon: <span class="font-semibold text-slate-700">{{ $dok->user->name }}</span> ({{ $dok->user->no_wa }})</p>
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

                        <div class="text-xs text-slate-600 p-2 bg-slate-50 rounded-xl flex justify-between">
                            <span>Metode: <strong>{{ $dok->metode_pengambilan }}</strong></span>
                            <span>{{ $dok->created_at->format('d M Y') }}</span>
                        </div>
                    </a>
                @empty
                    <p class="col-span-2 text-xs text-center text-slate-500 py-6">Tidak ada permohonan dokumen masuk.</p>
                @endforelse
                </div>
                {{ $staffDokumens->links() }}
            </div>

            <!-- My List inside Tab -->
            <div x-show="tab === 'my'" class="space-y-3">
                @include('permohonan-dokumen.partials.my-list')
            </div>
        </div>
    @else
        @include('permohonan-dokumen.partials.my-list')
    @endif
</div>
@endsection
