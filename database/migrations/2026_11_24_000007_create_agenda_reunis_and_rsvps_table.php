<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_reunis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['Reuni Akbar', 'Kajian Rutin', 'Temu Angkatan', 'Silaturahmi']);
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('lokasi');
            $table->decimal('biaya_donasi', 12, 2)->default(0);
            $table->unsignedInteger('kuota')->nullable();
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->string('kontak_person')->nullable();
            $table->timestamps();
        });

        Schema::create('agenda_rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_reuni_id')->constrained('agenda_reunis')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status_kehadiran', ['Hadir', 'Tidak Hadir', 'Ragu-ragu'])->default('Hadir');
            $table->unsignedSmallInteger('jumlah_tamu')->default(1);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['agenda_reuni_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_rsvps');
        Schema::dropIfExists('agenda_reunis');
    }
};
