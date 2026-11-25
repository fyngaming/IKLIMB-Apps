<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kajian_materis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori', 50); // Rekaman Kajian, Daurah Ilmiah, Artikel Ustaz, Tafsir & Hadis
            $table->string('nama_narasumber');
            $table->enum('media_type', ['youtube', 'audio', 'artikel'])->default('artikel');
            $table->string('media_url')->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('konten')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('tanya_ustazs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kategori_keilmuan', 50); // Fiqih, Aqidah, Muamalah, Keluarga & Pernikahan, Akhlaq
            $table->string('judul_pertanyaan');
            $table->text('pertanyaan');
            $table->boolean('is_anonim')->default(false);
            $table->enum('status', ['menunggu_jawaban', 'dijawab', 'ditolak'])->default('menunggu_jawaban');
            $table->foreignId('dijawab_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_ustaz_penjawab')->nullable();
            $table->text('jawaban')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        Schema::create('saran_masukans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('topik', 50); // Pengembangan Pondok, Kurikulum & Santri, Fasilitas & Sarpras, Jejaring Alumni, Lainnya
            $table->text('isi_aspirasi');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['terkirim', 'ditinjau', 'ditindaklanjuti', 'selesai'])->default('terkirim');
            $table->text('tanggapan_pondok')->nullable();
            $table->timestamp('ditanggapi_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saran_masukans');
        Schema::dropIfExists('tanya_ustazs');
        Schema::dropIfExists('kajian_materis');
    }
};
