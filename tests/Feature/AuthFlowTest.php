<?php

namespace Tests\Feature;

use App\Models\MasterSantri;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_matches_master_santri_and_sets_pending_status(): void
    {
        $santri = MasterSantri::create([
            'nis' => 'PPIB-2018-999',
            'nama_lengkap' => 'Muhammad Salman',
            'angkatan' => 'Angkatan 13 (2018)',
            'jenjang_pondok' => 'Madrasah Aliyah (MA)',
            'tahun_masuk' => 2015,
            'tahun_lulus' => 2018,
            'status_kelulusan' => 'Lulus',
            'is_registered' => false,
        ]);

        $response = $this->post('/daftar', [
            'no_wa' => '089876543210',
            'nis' => 'PPIB-2018-999',
            'name' => 'Muhammad Salman',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'Muhammad Salman',
            'no_wa' => '089876543210',
            'role' => 'alumni',
            'status' => 'menunggu_verifikasi',
            'is_first_login' => true,
        ]);

        $this->assertDatabaseHas('master_santri', [
            'nis' => 'PPIB-2018-999',
            'is_registered' => true,
        ]);
    }

    public function test_registration_fails_if_nis_not_in_master_santri(): void
    {
        $response = $this->post('/daftar', [
            'no_wa' => '089876543210',
            'nis' => 'FAKE-NIS-999',
            'name' => 'Orang Asing',
        ]);

        $response->assertSessionHasErrors('nis');
        $this->assertDatabaseMissing('users', [
            'no_wa' => '089876543210',
        ]);
    }

    public function test_coordinator_can_approve_registration_and_generate_activation(): void
    {
        $koordinator = User::create([
            'name' => 'Ust. Koordinator',
            'no_wa' => '081111111111',
            'password' => bcrypt('password'),
            'role' => 'koordinator',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        $user = User::create([
            'name' => 'Calon Alumni',
            'no_wa' => '082222222222',
            'password' => bcrypt('temp'),
            'role' => 'alumni',
            'status' => 'menunggu_verifikasi',
            'is_first_login' => true,
        ]);

        $response = $this->actingAs($koordinator)->post("/koordinator/verifikasi/{$user->id}/setujui");

        $response->assertRedirect();
        $user->refresh();
        $this->assertNotNull($user->activation_token);
        $this->assertNotNull($user->activation_expires_at);

        // Logout coordinator to simulate alumni opening activation link
        /** @var StatefulGuard $guard */
        $guard = Auth::guard('web');
        $guard->logout();
        $this->flushSession();

        // Test activation
        $actResponse = $this->post("/aktivasi/{$user->activation_token}", [
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $actResponse->assertRedirect('/onboarding');
        $user->refresh();
        $this->assertEquals('aktif', $user->status);
        $this->assertTrue(password_verify('secret123', $user->password));
    }

    public function test_login_and_first_login_onboarding_redirection(): void
    {
        $user = User::create([
            'name' => 'Alumni Baru',
            'no_wa' => '083333333333',
            'password' => bcrypt('password123'),
            'role' => 'alumni',
            'status' => 'aktif',
            'is_first_login' => true,
        ]);

        // Attempt to access /beranda should redirect to /onboarding
        $response = $this->actingAs($user)->get('/beranda');
        $response->assertRedirect('/onboarding');

        // Complete onboarding
        $saveResponse = $this->actingAs($user)->post('/onboarding', [
            'name' => 'Alumni Baru, S.T.',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1998-01-01',
            'angkatan' => '2016',
            'jenjang_pondok' => 'Madrasah Aliyah (MA)',
            'kabupaten_kota' => 'Jakarta Barat',
            'provinsi' => 'DKI Jakarta',
            'negara' => 'Indonesia',
            'status_pernikahan' => 'Belum Menikah',
            'pekerjaan_lembaga' => 'Tech Corp',
            'educations' => [
                [
                    'jenjang' => 'S1',
                    'nama_universitas' => 'Institut Teknologi Bandung',
                    'program_studi' => 'Teknik Elektro',
                    'tahun_lulus' => 2021,
                ],
            ],
        ]);

        $saveResponse->assertRedirect('/beranda');
        $user->refresh();
        $this->assertFalse($user->is_first_login);
        $this->assertEquals('Alumni Baru, S.T.', $user->name);
    }

    public function test_admin_login_and_beranda_redirect_directly_to_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'no_wa' => '087777777777',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        $response = $this->post('/login', [
            'no_wa' => '087777777777',
            'password' => 'password123',
        ]);
        $response->assertRedirect(route('admin.dashboard'));

        // Accessing /beranda as admin directly redirects to admin dashboard
        $berandaResponse = $this->actingAs($admin)->get('/beranda');
        $berandaResponse->assertRedirect(route('admin.dashboard'));

        // Logout before quick login because quick login route is guarded by 'guest' middleware
        Auth::logout();
        $this->flushSession();

        // Quick login demo admin redirects to admin dashboard
        $quickAdminResponse = $this->get('/login/quick/admin');
        $quickAdminResponse->assertRedirect(route('admin.dashboard'));
    }
}
