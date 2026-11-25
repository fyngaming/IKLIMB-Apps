@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4">
    <div class="flex items-center space-x-2 border-b pb-3 border-slate-200">
        <a href="{{ route('permohonan-dokumen.index') }}" class="p-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600">
            &larr;
        </a>
        <div>
            <h1 class="text-base font-extrabold text-slate-800">Form Permohonan Dokumen</h1>
            <p class="text-xs text-slate-500">Layanan Administrasi & Tata Usaha PPIB</p>
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

    <form action="{{ route('permohonan-dokumen.store') }}" method="POST" class="space-y-3.5" x-data="{ metode: 'Ambil Langsung di Pos/TU' }">
        @csrf

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Dokumen yang Dimohon <span class="text-rose-500">*</span></label>
                <select name="jenis_dokumen" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    <option value="Legalisasi Ijazah Pondok">Legalisasi Ijazah Pondok</option>
                    <option value="Surat Keterangan Alumni">Surat Keterangan Alumni PPIB</option>
                    <option value="Surat Rekomendasi Studi Lanjut">Surat Rekomendasi Studi Lanjut (S1/S2/Timur Tengah)</option>
                    <option value="Transkrip Nilai / Rapor Santri">Transkrip Nilai / Rapor Santri</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Keperluan Permohonan <span class="text-rose-500">*</span></label>
                <textarea name="keperluan" rows="2" required placeholder="Contoh: Pendaftaran beasiswa kuliah di Universitas Al-Azhar Kairo / Melamar pekerjaan..."
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">{{ old('keperluan') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Eksemplar <span class="text-rose-500">*</span></label>
                    <input type="number" name="jumlah_eksemplar" value="{{ old('jumlah_eksemplar', 2) }}" min="1" max="20" required
                        class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Metode Pengambilan <span class="text-rose-500">*</span></label>
                    <select name="metode_pengambilan" x-model="metode" required class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl">
                        <option value="Ambil Langsung di Pos/TU">Ambil Langsung di Pos/TU</option>
                        <option value="Kirim via Ekspedisi">Kirim via Ekspedisi (JNE/J&T)</option>
                        <option value="Digital (PDF Berstempel)">Digital (File PDF)</option>
                    </select>
                </div>
            </div>

            <div x-show="metode === 'Kirim via Ekspedisi'" class="space-y-1">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap Pengiriman Berkas</label>
                <textarea name="alamat_pengiriman" rows="2" placeholder="Nama penerima, No HP, Alamat lengkap jalan, RT/RW, Kecamatan, Kota, Kode Pos..."
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl">{{ old('alamat_pengiriman') }}</textarea>
                <p class="text-[10px] text-slate-500">Biaya ongkir ekspedisi dibayarkan saat berkas tiba (COD) atau ditransfer ke rekening pondok.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tautan Berkas Pendukung (Opsional)</label>
                <input type="text" name="file_lampiran" value="{{ old('file_lampiran') }}" placeholder="Link Google Drive / Scan Ijazah Lama / KTP"
                    class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-300 rounded-xl">
                <p class="text-[10px] text-slate-500 mt-0.5">Sertakan scan ijazah atau KTP jika legalisasi memerlukan verifikasi berkas awal.</p>
            </div>
        </div>

        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-emerald-800 to-emerald-700 hover:from-emerald-900 text-white font-bold text-sm shadow-md transition transform active:scale-95">
            Kirim Permohonan Dokumen &rarr;
        </button>
    </form>
</div>
@endsection
