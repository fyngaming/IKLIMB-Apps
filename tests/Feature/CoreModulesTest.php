<?php

namespace Tests\Feature;

use App\Models\AlumniProfile;
use App\Models\KabarPondok;
use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreModulesTest extends TestCase
{
    use RefreshDatabase;

    private User $alumni;

    private User $keamanan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->alumni = User::create([
            'name' => 'Hasan Basri',
            'no_wa' => '081299990001',
            'password' => bcrypt('password'),
            'role' => 'alumni',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        AlumniProfile::create([
            'user_id' => $this->alumni->id,
            'nis' => 'PPIB-2015-001',
            'qr_identity_token' => 'IKLIMB-HASAN01',
            'angkatan' => '2015',
            'jenjang_pondok' => 'Madrasah Aliyah (MA)',
            'kabupaten_kota' => 'Depok',
            'provinsi' => 'Jawa Barat',
            'negara' => 'Indonesia',
            'privacy_settings' => [
                'show_wa' => true,
                'show_address' => true,
                'show_job' => true,
                'show_education' => true,
            ],
        ]);

        $this->keamanan = User::create([
            'name' => 'Petugas Satpam',
            'no_wa' => '081299990002',
            'password' => bcrypt('password'),
            'role' => 'keamanan',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);
    }

    public function test_beranda_and_kartu_alumni_qr_render_successfully(): void
    {
        $response = $this->actingAs($this->alumni)->get('/beranda');
        $response->assertStatus(200);
        $response->assertSee('IKLIMB Apps');
        $response->assertSee('Hasan Basri');
        $response->assertSee('Semua Layanan IKLIMB');
        $response->assertSee(route('kabar-pondok.index'));
        $response->assertSee('grid-cols-5');

        $qrCardResponse = $this->actingAs($this->alumni)->get('/kartu-alumni');
        $qrCardResponse->assertStatus(200);
        $qrCardResponse->assertSee('IKLIMB-HASAN01');
        $qrCardResponse->assertSee('<svg', false); // Confirms SVG QR code is rendered

        // Security guard visiting kartu-alumni is redirected to scanner pos
        $keamananResponse = $this->actingAs($this->keamanan)->get('/kartu-alumni');
        $keamananResponse->assertRedirect(route('keamanan.scanner'));

        // Koordinator visiting /beranda sees koordinator badge and not NIS: -
        $koordinator = User::create([
            'name' => 'Ust. Koordinator',
            'no_wa' => '081299990003',
            'password' => bcrypt('password'),
            'role' => 'koordinator',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        $koordinatorResponse = $this->actingAs($koordinator)->get('/beranda');
        $koordinatorResponse->assertStatus(200);
        $koordinatorResponse->assertSee('Koordinator Angkatan');
        $koordinatorResponse->assertSee('Pengurus Koordinator');
        $koordinatorResponse->assertSee('Koordinator Aktif');
        $koordinatorResponse->assertDontSee('NIS: -');
    }

    public function test_kunjungan_flow_and_security_qr_verification(): void
    {
        // 1. Submit visit request
        $response = $this->actingAs($this->alumni)->post('/kunjungan', [
            'tanggal_kunjungan' => date('Y-m-d'),
            'jam_kunjungan' => '10:00',
            'tujuan' => 'Silaturahmi dengan Ustaz',
            'pihak_ditemui' => 'Pengasuh Pesantren',
            'jumlah_rombongan' => 2,
            'kendaraan' => 'Mobil',
        ]);

        $response->assertRedirect();
        $kunjungan = Kunjungan::where('user_id', $this->alumni->id)->first();
        $this->assertNotNull($kunjungan);
        $this->assertNotNull($kunjungan->qr_visit_token);

        // 2. Security officer scans the visit token
        $scanResponse = $this->actingAs($this->keamanan)->postJson('/keamanan/verify', [
            'code' => $kunjungan->qr_visit_token,
        ]);

        $scanResponse->assertStatus(200);
        $scanResponse->assertJson([
            'success' => true,
            'type' => 'kunjungan',
        ]);

        // 3. Security check-in
        $checkInResponse = $this->actingAs($this->keamanan)->postJson("/keamanan/check-in/{$kunjungan->id}");
        $checkInResponse->assertStatus(200);
        $kunjungan->refresh();
        $this->assertNotNull($kunjungan->checked_in_at);
        $this->assertEquals('selesai', $kunjungan->status);
    }

    public function test_permohonan_dokumen_and_kabar_pondok(): void
    {
        // Kabar Pondok
        KabarPondok::create([
            'user_id' => $this->alumni->id,
            'judul' => 'Ujian Akhir Santri PPIB Berjalan Lancar',
            'slug' => 'ujian-akhir-santri-lancar',
            'kategori' => 'Berita',
            'ringkasan' => 'Pelaksanaan ujian akhir berjalan khidmat.',
            'konten' => 'Seluruh santri mengikuti ujian dengan tertib.',
            'published_at' => now(),
        ]);

        $kabarResponse = $this->actingAs($this->alumni)->get('/kabar-pondok');
        $kabarResponse->assertStatus(200);
        $kabarResponse->assertSee('Ujian Akhir Santri PPIB Berjalan Lancar');

        // Permohonan Dokumen
        $dokResponse = $this->actingAs($this->alumni)->post('/permohonan-dokumen', [
            'jenis_dokumen' => 'Surat Keterangan Alumni',
            'keperluan' => 'Pemberkasan beasiswa',
            'jumlah_eksemplar' => 2,
            'metode_pengambilan' => 'Digital (PDF Berstempel)',
        ]);

        $dokResponse->assertRedirect();
        $this->assertDatabaseHas('permohonan_dokumens', [
            'user_id' => $this->alumni->id,
            'jenis_dokumen' => 'Surat Keterangan Alumni',
            'status' => 'diajukan',
        ]);
    }
}
