<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_lowongan_usahas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('tipe', ['lowongan_kerja', 'kebutuhan_dai', 'usaha_alumni']);
            $table->string('judul');
            $table->string('nama_perusahaan_usaha');
            $table->string('bidang_industri')->nullable();
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->string('kontak_wa', 30);
            $table->string('link_website')->nullable();
            $table->string('foto_brosur')->nullable();
            $table->boolean('is_verified')->default(true);
            $table->timestamps();
        });

        Schema::create('forum_angkatans', function (Blueprint $table) {
            $table->id();
            $table->string('angkatan', 100);
            $table->year('tahun_lulus');
            $table->string('nama_koordinator');
            $table->string('no_wa_koordinator', 30);
            $table->string('link_wa_group');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_angkatans');
        Schema::dropIfExists('info_lowongan_usahas');
    }
};
