<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kode_kunjungan', 50)->unique()->index();
            $table->string('qr_visit_token', 100)->unique();
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan');
            $table->string('tujuan', 100); // Silaturahmi dengan Ustaz, Menjenguk Santri, Urusan Administrasi, Lainnya
            $table->string('pihak_ditemui');
            $table->unsignedSmallInteger('jumlah_rombongan')->default(1);
            $table->string('kendaraan')->nullable(); // contoh: Mobil (B 1234 ABC)
            $table->boolean('is_menginap')->default(false);
            $table->text('catatan_alumni')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'dijadwalkan_ulang', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('catatan_petugas')->nullable();
            $table->date('jadwal_ulang_tanggal')->nullable();
            $table->time('jadwal_ulang_jam')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
