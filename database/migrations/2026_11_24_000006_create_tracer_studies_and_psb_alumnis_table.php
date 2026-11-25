<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->year('tahun_survey');
            $table->enum('status_kiprah', ['Bekerja', 'Wirausaha', 'Studi Lanjut', 'Dakwah / Pengabdian', 'Mencari Kerja']);
            $table->string('nama_instansi')->nullable();
            $table->string('pendapatan_rata_rata', 50)->nullable();
            $table->enum('keselarasan_ilmu', ['Sangat Selaras', 'Cukup Selaras', 'Kurang Selaras'])->nullable();
            $table->text('kontribusi_pondok_feedback')->nullable();
            $table->text('saran_kurikulum')->nullable();
            $table->timestamps();
        });

        Schema::create('psb_alumnis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Akun alumni pendaftar
            $table->string('nomor_registrasi', 50)->unique();
            $table->string('nama_calon_santri');
            $table->string('hubungan_keluarga', 50); // Anak Kandung, Adik, Keponakan, Kerabat
            $table->string('nisn', 50)->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('jenjang_pilihan', 50); // MTs PPIB, MA PPIB, Takhasus Tahfizh
            $table->string('berkas_rapor')->nullable();
            $table->enum('status_seleksi', ['pendaftaran', 'berkas_diverifikasi', 'tes_masuk', 'lulus', 'tidak_lulus'])->default('pendaftaran');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psb_alumnis');
        Schema::dropIfExists('tracer_studies');
    }
};
