<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('master_santri_id')->nullable()->constrained('master_santri')->nullOnDelete();
            $table->string('nis', 50)->nullable()->index();
            $table->string('qr_identity_token', 100)->unique();
            $table->string('angkatan', 50)->nullable();
            $table->string('jenjang_pondok', 50)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('status_pernikahan', ['Belum Menikah', 'Menikah', 'Cerai'])->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('negara')->default('Indonesia');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('pekerjaan_lembaga')->nullable();
            $table->string('pekerjaan_divisi')->nullable();
            $table->string('pekerjaan_jabatan')->nullable();
            $table->text('bio')->nullable();
            $table->json('privacy_settings')->nullable();
            $table->timestamps();
        });

        Schema::create('alumni_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_profile_id')->constrained('alumni_profiles')->cascadeOnDelete();
            $table->enum('jenjang', ['D3', 'D4', 'S1', 'S2', 'S3']);
            $table->string('nama_universitas');
            $table->string('program_studi');
            $table->year('tahun_masuk')->nullable();
            $table->year('tahun_lulus');
            $table->string('gelar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_educations');
        Schema::dropIfExists('alumni_profiles');
    }
};
