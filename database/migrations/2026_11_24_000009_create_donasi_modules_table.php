<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi_programs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori', 50); // Wakaf Pembangunan, Beasiswa Santri, Operasional Dakwah, Tanggap Bencana
            $table->decimal('target_dana', 15, 2);
            $table->decimal('dana_terkumpul', 15, 2)->default(0);
            $table->date('tanggal_berakhir')->nullable();
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('donasi_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donasi_program_id')->constrained('donasi_programs')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_donatur');
            $table->string('no_wa_donatur', 30)->nullable();
            $table->decimal('nominal', 15, 2);
            $table->string('bukti_transfer')->nullable();
            $table->boolean('is_anonim')->default(false);
            $table->enum('status', ['menunggu_konfirmasi', 'terverifikasi', 'dibatalkan'])->default('menunggu_konfirmasi');
            $table->text('doa_harapan')->nullable();
            $table->timestamps();
        });

        Schema::create('donasi_penyalurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donasi_program_id')->constrained('donasi_programs')->cascadeOnDelete();
            $table->string('judul_penyaluran');
            $table->decimal('nominal_disalurkan', 15, 2);
            $table->date('tanggal_penyaluran');
            $table->text('laporan_kegiatan');
            $table->string('foto_dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_penyalurans');
        Schema::dropIfExists('donasi_transaksis');
        Schema::dropIfExists('donasi_programs');
    }
};
