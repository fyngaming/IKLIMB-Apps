<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_permohonan', 50)->unique()->index();
            $table->string('jenis_dokumen', 100); // Legalisasi Ijazah, Surat Keterangan Alumni, Surat Rekomendasi Studi Lanjut
            $table->text('keperluan');
            $table->unsignedSmallInteger('jumlah_eksemplar')->default(1);
            $table->string('metode_pengambilan', 50)->default('Ambil Langsung di Pos/TU'); // Ambil Langsung di Pos/TU, Kirim via Ekspedisi, Digital (PDF)
            $table->text('alamat_pengiriman')->nullable();
            $table->string('file_lampiran')->nullable(); // berkas pendukung
            $table->string('file_hasil')->nullable(); // PDF hasil terbit jika digital
            $table->enum('status', ['diajukan', 'diverifikasi', 'diproses', 'siap_diambil', 'selesai', 'ditolak'])->default('diajukan');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_dokumens');
    }
};
