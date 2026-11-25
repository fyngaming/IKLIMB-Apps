<?php

namespace Tests\Feature;

use App\Models\DonasiProgram;
use App\Models\PermohonanDokumen;
use App\Models\TanyaUstaz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $alumni = User::create([
            'name' => 'Ahmad Alumni',
            'no_wa' => '081234567890',
            'password' => bcrypt('password'),
            'role' => 'alumni',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        $response = $this->actingAs($alumni)->get('/admin');
        $response->assertForbidden();
    }

    public function test_admin_can_access_dashboard_and_manage_modules(): void
    {
        $admin = User::create([
            'name' => 'KH. Abdullah Hakim',
            'no_wa' => '081111111111',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        // 1. Overview Dashboard
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertOk();
        $response->assertSee('Dashboard Panel Admin IKLIMB');
        $response->assertDontSee('Semua Layanan');

        // 2. Buka Program Donasi Baru dengan File Upload
        Storage::fake('public');
        $donasiFile = UploadedFile::fake()->image('banner_donasi.jpg');

        $donasiResponse = $this->actingAs($admin)->post('/admin/donasi-wakaf', [
            'judul' => 'Pembebasan Tanah Wakaf Asrama Santri',
            'kategori' => 'Wakaf Pembangunan',
            'target_dana' => 75000000,
            'tanggal_berakhir' => now()->addMonths(3)->format('Y-m-d'),
            'deskripsi' => 'Program penggalangan dana untuk pembebasan 500m2 lahan pesantren tahfizh.',
            'gambar_file' => $donasiFile,
            'is_aktif' => true,
        ]);
        $donasiResponse->assertRedirect('/admin/donasi-wakaf');
        $this->assertDatabaseHas('donasi_programs', [
            'judul' => 'Pembebasan Tanah Wakaf Asrama Santri',
            'target_dana' => 75000000,
        ]);
        $program = DonasiProgram::where('judul', 'Pembebasan Tanah Wakaf Asrama Santri')->first();
        $this->assertStringStartsWith('/storage/donasi/', $program->gambar);

        // 3. Tulis Kabar Pondok dengan URL Link
        $kabarResponse = $this->actingAs($admin)->post('/admin/kabar-pondok', [
            'judul' => 'Pengumuman Daurah Ilmiah Ramadhan 1448 H',
            'kategori' => 'Pengumuman Resmi',
            'ringkasan' => 'Pendaftaran daurah intensif telah dibuka untuk seluruh alumni.',
            'konten' => 'Isi pengumuman lengkap terkait jadwal daurah dan asatizah.',
            'gambar_url' => 'https://images.unsplash.com/photo-test-daurah.jpg',
            'status' => 'published',
        ]);
        $kabarResponse->assertRedirect('/admin/kabar-pondok');
        $this->assertDatabaseHas('kabar_pondoks', [
            'judul' => 'Pengumuman Daurah Ilmiah Ramadhan 1448 H',
            'gambar' => 'https://images.unsplash.com/photo-test-daurah.jpg',
        ]);

        // 4. Update Status Dokumen TU
        $doc = PermohonanDokumen::create([
            'user_id' => $admin->id,
            'nomor_permohonan' => 'DOK-TEST-001',
            'jenis_dokumen' => 'Legalisasi Ijazah',
            'keperluan' => 'Pendaftaran CPNS',
            'jumlah_eksemplar' => 3,
            'metode_pengambilan' => 'ambil_langsung',
            'status' => 'diajukan',
        ]);

        $docResponse = $this->actingAs($admin)->post("/admin/dokumen-tu/{$doc->id}/status", [
            'status' => 'siap_diambil',
            'catatan_admin' => 'Dokumen sudah selesai ditandatangani dan siap diambil di Pos TU.',
        ]);
        $docResponse->assertRedirect('/admin/dokumen-tu');
        $this->assertDatabaseHas('permohonan_dokumens', [
            'id' => $doc->id,
            'status' => 'siap_diambil',
        ]);

        // 5. Tambah Kajian Baru
        $kajianResponse = $this->actingAs($admin)->post('/admin/kajian-materi', [
            'judul' => 'Syarah Arbain Nawawiyyah: Hadits 1',
            'nama_narasumber' => 'KH. Abdullah Hakim, Lc.',
            'kategori' => 'Hadits & Sunnah',
            'media_type' => 'youtube',
            'media_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'ringkasan' => 'Pembahasan niat dan keikhlasan dalam beramal.',
        ]);
        $kajianResponse->assertRedirect('/admin/kajian-materi');
        $this->assertDatabaseHas('kajian_materis', [
            'judul' => 'Syarah Arbain Nawawiyyah: Hadits 1',
        ]);

        // 6. Jawab Tanya Ustaz
        $question = TanyaUstaz::create([
            'user_id' => $admin->id,
            'kategori_keilmuan' => 'Fiqih Kontemporer',
            'judul_pertanyaan' => 'Hukum zakat fitrah dengan uang tunai',
            'pertanyaan' => 'Apakah diperbolehkan membayar zakat fitrah dengan uang tunai?',
            'status' => 'menunggu_jawaban',
        ]);

        $answerResponse = $this->actingAs($admin)->post("/admin/tanya-ustaz/{$question->id}/jawab", [
            'nama_ustaz_penjawab' => 'KH. Abdullah Hakim, Lc.',
            'jawaban' => 'Berdasarkan madzhab Hanafi, diperbolehkan mengeluarkan nilai uang seharga beras.',
            'is_public' => true,
        ]);
        $answerResponse->assertRedirect('/admin/tanya-ustaz');
        $this->assertDatabaseHas('tanya_ustazs', [
            'id' => $question->id,
            'status' => 'dijawab',
            'is_public' => true,
        ]);
    }
}
