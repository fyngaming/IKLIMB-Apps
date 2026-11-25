@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4">
    <div class="flex items-center space-x-2 border-b pb-3 border-slate-200">
        <a href="{{ route('kunjungan.index') }}" class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">
            &larr;
        </a>
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Form Pengajuan Kunjungan</h1>
            <p class="text-xs text-slate-500">Kunjungan ke Pondok Pesantren PPIB</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kunjungan.store') }}" method="POST" class="space-y-3.5">
        @csrf

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Kunjungan <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required min="{{ date('Y-m-d') }}"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Perkiraan Jam Tiba <span class="text-rose-500">*</span></label>
                    <input type="time" name="jam_kunjungan" value="{{ old('jam_kunjungan', '09:00') }}" required
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tujuan Kunjungan <span class="text-rose-500">*</span></label>
                <select name="tujuan" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    <option value="Silaturahmi dengan Ustaz">Silaturahmi dengan Ustaz / Pengasuh</option>
                    <option value="Menjenguk Santri">Menjenguk Santri / Adik Kelas</option>
                    <option value="Urusan Administrasi">Urusan Administrasi / Ijazah</option>
                    <option value="Kegiatan Reuni / Angkatan">Kegiatan Reuni / Temu Angkatan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pihak yang Ingin Ditemui <span class="text-rose-500">*</span></label>
                <input type="text" name="pihak_ditemui" value="{{ old('pihak_ditemui') }}" required placeholder="Contoh: Ust. Ahmad Fauzi / Santri Muhammad"
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Rombongan <span class="text-rose-500">*</span></label>
                    <input type="number" name="jumlah_rombongan" value="{{ old('jumlah_rombongan', 1) }}" min="1" max="50" required
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kendaraan & Plat</label>
                    <input type="text" name="kendaraan" value="{{ old('kendaraan') }}" placeholder="Contoh: Mobil (B 1234 ABC)"
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div class="pt-1">
                <label class="flex items-center space-x-2.5 p-2 bg-slate-50 rounded-xl cursor-pointer border border-slate-200">
                    <input type="checkbox" name="is_menginap" value="1" {{ old('is_menginap') ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Rencana Menginap di Wisma Pondok</span>
                        <span class="text-[10px] text-slate-500">Konfirmasi ketersediaan kamar wisma tamu santri</span>
                    </div>
                </label>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan_alumni" rows="2" placeholder="Informasi tambahan untuk pengurus..."
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">{{ old('catatan_alumni') }}</textarea>
            </div>
        </div>

        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 text-white font-bold text-sm shadow-md transition transform active:scale-95">
            Kirim Pengajuan Kunjungan &rarr;
        </button>
    </form>
</div>
@endsection
