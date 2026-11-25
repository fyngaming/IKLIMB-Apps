<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_santri', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50)->unique()->index();
            $table->string('nama_lengkap');
            $table->string('angkatan', 50); // contoh: "Angkatan 10 (2015)" atau "2015"
            $table->string('jenjang_pondok', 50); // MTs, MA, Takhasus
            $table->year('tahun_masuk')->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('status_kelulusan', 50)->default('Lulus');
            $table->boolean('is_registered')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_santri');
    }
};
