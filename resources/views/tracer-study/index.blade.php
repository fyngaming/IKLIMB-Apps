@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-900 to-emerald-800 text-white p-5 rounded-3xl shadow-lg">
        <span class="text-[10px] font-bold text-gold-300 uppercase tracking-wider block">Akreditasi & Pengembangan Pondok</span>
        <h1 class="text-base font-extrabold text-white mt-0.5">Pendataan Alumni (Tracer Study)</h1>
        <p class="text-xs text-emerald-200 mt-1 leading-relaxed">
            Bantu kami memetakan kiprah alumni PPIB di berbagai bidang untuk penguatan kurikulum dan akreditasi lembaga.
        </p>
    </div>

    <!-- Quick Stats Rekapitulasi -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-2">
        <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Rekapitulasi Kiprah Alumni ({{ $stats['total'] }} Responden)</h2>
        <div class="grid grid-cols-4 gap-2 text-center text-xs pt-1">
            <div class="p-2 bg-blue-50 rounded-xl border border-blue-100">
                <span class="font-bold text-sm text-blue-800 block">{{ $stats['bekerja'] }}</span>
                <span class="text-[9px] text-slate-500">Bekerja</span>
            </div>
            <div class="p-2 bg-emerald-50 rounded-xl border border-emerald-100">
                <span class="font-bold text-sm text-emerald-800 block">{{ $stats['wirausaha'] }}</span>
                <span class="text-[9px] text-slate-500">Wirausaha</span>
            </div>
            <div class="p-2 bg-purple-50 rounded-xl border border-purple-100">
                <span class="font-bold text-sm text-purple-800 block">{{ $stats['studi_lanjut'] }}</span>
                <span class="text-[9px] text-slate-500">Studi</span>
            </div>
            <div class="p-2 bg-amber-50 rounded-xl border border-amber-100">
                <span class="font-bold text-sm text-amber-800 block">{{ $stats['dakwah'] }}</span>
                <span class="text-[9px] text-slate-500">Dakwah</span>
            </div>
        </div>
    </div>

    <!-- Questionnaire Form -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-3">
        <div class="border-b pb-2">
            <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Kuesioner Tracer Alumni {{ date('Y') }}</h2>
            <p class="text-[11px] text-slate-500">Isi data terkini Anda di bawah ini:</p>
        </div>

        <form action="{{ route('tracer-study.store') }}" method="POST" class="space-y-3 text-xs">
            @csrf

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Status Aktivitas Utama Saat Ini <span class="text-rose-500">*</span></label>
                <select name="status_kiprah" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                    <option value="Bekerja" {{ old('status_kiprah', optional($myTracer)->status_kiprah) === 'Bekerja' ? 'selected' : '' }}>Bekerja (Karyawan / ASN / Profesional)</option>
                    <option value="Wirausaha" {{ old('status_kiprah', optional($myTracer)->status_kiprah) === 'Wirausaha' ? 'selected' : '' }}>Wirausaha / Membuka Usaha Sendiri</option>
                    <option value="Studi Lanjut" {{ old('status_kiprah', optional($myTracer)->status_kiprah) === 'Studi Lanjut' ? 'selected' : '' }}>Studi Lanjut (Kuliah S1 / S2 / S3)</option>
                    <option value="Dakwah / Pengabdian" {{ old('status_kiprah', optional($myTracer)->status_kiprah) === 'Dakwah / Pengabdian' ? 'selected' : '' }}>Dakwah / Mengajar Pesantren / Khidmat</option>
                    <option value="Mencari Kerja" {{ old('status_kiprah', optional($myTracer)->status_kiprah) === 'Mencari Kerja' ? 'selected' : '' }}>Sedang Mencari Peluang Kerja</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Nama Instansi / Perusahaan / Kampus</label>
                <input type="text" name="nama_instansi" value="{{ old('nama_instansi', optional($myTracer)->nama_instansi) }}" placeholder="Contoh: PT Telkom / Universitas Brawijaya / Pesantren"
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Rentang Penghasilan</label>
                    <select name="pendapatan_rata_rata" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                        <option value="< Rp 3 Juta">< Rp 3 Juta</option>
                        <option value="Rp 3 - 5 Juta" selected>Rp 3 - 5 Juta</option>
                        <option value="Rp 5 - 10 Juta">Rp 5 - 10 Juta</option>
                        <option value="> Rp 10 Juta">> Rp 10 Juta</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Keselarasan Ilmu Pondok</label>
                    <select name="keselarasan_ilmu" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">
                        <option value="Sangat Selaras">Sangat Selaras</option>
                        <option value="Cukup Selaras">Cukup Selaras</option>
                        <option value="Kurang Selaras">Kurang Selaras</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Masukan untuk Kurikulum & Pembinaan Santri PPIB</label>
                <textarea name="saran_kurikulum" rows="2" placeholder="Saran keilmuan, bahasa, adab, teknologi..."
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl">{{ old('saran_kurikulum', optional($myTracer)->saran_kurikulum) }}</textarea>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs rounded-xl shadow transition">
                Simpan Partisipasi Tracer Study
            </button>
        </form>
    </div>
</div>
@endsection
