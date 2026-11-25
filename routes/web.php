<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OnboardingController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DirektoriAlumniController;
use App\Http\Controllers\DonasiWakafController;
use App\Http\Controllers\EcosystemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KabarPondokController;
use App\Http\Controllers\Keamanan\ScannerController;
use App\Http\Controllers\Koordinator\VerificationController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PermohonanDokumenController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TracerStudyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IKLIMB Apps Web Routes - Pondok Pesantren PPIB
|--------------------------------------------------------------------------
*/

// Redirect root to beranda / login
Route::get('/', function () {
    return redirect()->route('home');
});

// Guest & Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/login/quick/{role}', [AuthController::class, 'quickLogin'])->name('login.quick');

    Route::get('/daftar', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/daftar/sukses/{id}', [RegisterController::class, 'success'])->name('register.success');

    Route::get('/aktivasi/{token}', [ActivationController::class, 'showActivationForm'])->name('activation.form');
    Route::post('/aktivasi/{token}', [ActivationController::class, 'submitActivation'])->name('activation.submit');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Verification Pending Notice
    Route::get('/verifikasi/menunggu', [RegisterController::class, 'verificationNotice'])->name('verification.notice');

    // Onboarding (First Login)
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding.index');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // Core Features (Requires Profile Completed / Onboarded)
    Route::middleware('onboarded')->group(function () {
        // Beranda
        Route::get('/beranda', [HomeController::class, 'index'])->name('home');

        // Profil & Kartu Digital
        Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
        Route::post('/profil/privasi', [ProfilController::class, 'updatePrivacy'])->name('profil.privacy');
        Route::get('/kartu-alumni', [ProfilController::class, 'kartuAlumni'])->name('kartu-alumni');

        // Kunjungan ke Pondok
        Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
        Route::get('/kunjungan/ajukan', [KunjunganController::class, 'create'])->name('kunjungan.create');
        Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
        Route::get('/kunjungan/{id}', [KunjunganController::class, 'show'])->name('kunjungan.show');
        Route::post('/kunjungan/{id}/status', [KunjunganController::class, 'updateStatus'])->name('kunjungan.status');

        // Kabar Pondok
        Route::get('/kabar-pondok', [KabarPondokController::class, 'index'])->name('kabar-pondok.index');
        Route::get('/kabar-pondok/tulis', [KabarPondokController::class, 'create'])->name('kabar-pondok.create');
        Route::post('/kabar-pondok', [KabarPondokController::class, 'store'])->name('kabar-pondok.store');
        Route::get('/kabar-pondok/{slug}', [KabarPondokController::class, 'show'])->name('kabar-pondok.show');

        // Permohonan Dokumen
        Route::get('/permohonan-dokumen', [PermohonanDokumenController::class, 'index'])->name('permohonan-dokumen.index');
        Route::get('/permohonan-dokumen/ajukan', [PermohonanDokumenController::class, 'create'])->name('permohonan-dokumen.create');
        Route::post('/permohonan-dokumen', [PermohonanDokumenController::class, 'store'])->name('permohonan-dokumen.store');
        Route::get('/permohonan-dokumen/{id}', [PermohonanDokumenController::class, 'show'])->name('permohonan-dokumen.show');
        Route::post('/permohonan-dokumen/{id}/status', [PermohonanDokumenController::class, 'updateStatus'])->name('permohonan-dokumen.status');

        // Tahap 2: Direktori Alumni, Tracer Study, Donasi & Wakaf
        Route::get('/direktori-alumni', [DirektoriAlumniController::class, 'index'])->name('direktori-alumni.index');
        Route::get('/tracer-study', [TracerStudyController::class, 'index'])->name('tracer-study.index');
        Route::post('/tracer-study', [TracerStudyController::class, 'store'])->name('tracer-study.store');
        Route::get('/donasi-wakaf', [DonasiWakafController::class, 'index'])->name('donasi-wakaf.index');
        Route::post('/donasi-wakaf/{id}/transaksi', [DonasiWakafController::class, 'storeTransaksi'])->name('donasi-wakaf.transaksi');

        // Tahap 3: PSB, Agenda/RSVP, Lowongan, Peta Sebaran, Forum, Kajian, Tanya Ustaz, Saran
        Route::get('/psb-alumni', [EcosystemController::class, 'psbIndex'])->name('psb-alumni.index');
        Route::post('/psb-alumni', [EcosystemController::class, 'psbStore'])->name('psb-alumni.store');

        Route::get('/agenda-reuni', [EcosystemController::class, 'agendaIndex'])->name('agenda-reuni.index');
        Route::post('/agenda-reuni/{id}/rsvp', [EcosystemController::class, 'agendaRsvp'])->name('agenda-reuni.rsvp');

        Route::get('/info-lowongan-usaha', [EcosystemController::class, 'lowonganIndex'])->name('info-lowongan-usaha.index');
        Route::post('/info-lowongan-usaha', [EcosystemController::class, 'lowonganStore'])->name('info-lowongan-usaha.store');

        Route::get('/peta-alumni', [EcosystemController::class, 'petaIndex'])->name('peta-alumni.index');
        Route::get('/forum-angkatan', [EcosystemController::class, 'forumIndex'])->name('forum-angkatan.index');
        Route::get('/kajian-materi', [EcosystemController::class, 'kajianIndex'])->name('kajian-materi.index');

        Route::get('/tanya-ustaz', [EcosystemController::class, 'tanyaUstazIndex'])->name('tanya-ustaz.index');
        Route::post('/tanya-ustaz', [EcosystemController::class, 'tanyaUstazStore'])->name('tanya-ustaz.store');

        Route::get('/saran-masukan', [EcosystemController::class, 'saranIndex'])->name('saran-masukan.index');
        Route::post('/saran-masukan', [EcosystemController::class, 'saranStore'])->name('saran-masukan.store');
    });

    // Koordinator & Admin Protected Routes
    Route::middleware('role:koordinator,admin')->group(function () {
        Route::get('/koordinator/verifikasi', [VerificationController::class, 'index'])->name('koordinator.verifikasi');
        Route::post('/koordinator/verifikasi/{id}/setujui', [VerificationController::class, 'approve'])->name('koordinator.verifikasi.approve');
        Route::post('/koordinator/verifikasi/{id}/tolak', [VerificationController::class, 'reject'])->name('koordinator.verifikasi.reject');
    });

    // Keamanan (Pos Satpam) & Admin Protected Routes
    Route::middleware('role:keamanan,admin')->group(function () {
        Route::get('/keamanan/scanner', [ScannerController::class, 'index'])->name('keamanan.scanner');
        Route::post('/keamanan/verify', [ScannerController::class, 'verifyCode'])->name('keamanan.verify');
        Route::post('/keamanan/check-in/{id}', [ScannerController::class, 'checkIn'])->name('keamanan.check-in');
    });

    // Admin Control Center (Full Management of All Aspects)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // 1. Kabar Pondok
        Route::get('/kabar-pondok', [AdminDashboardController::class, 'kabarIndex'])->name('kabar.index');
        Route::post('/kabar-pondok', [AdminDashboardController::class, 'kabarStore'])->name('kabar.store');
        Route::put('/kabar-pondok/{id}', [AdminDashboardController::class, 'kabarUpdate'])->name('kabar.update');
        Route::delete('/kabar-pondok/{id}', [AdminDashboardController::class, 'kabarDestroy'])->name('kabar.destroy');

        // 2. Donasi & Wakaf
        Route::get('/donasi-wakaf', [AdminDashboardController::class, 'donasiIndex'])->name('donasi.index');
        Route::post('/donasi-wakaf', [AdminDashboardController::class, 'donasiStore'])->name('donasi.store');
        Route::put('/donasi-wakaf/{id}', [AdminDashboardController::class, 'donasiUpdate'])->name('donasi.update');
        Route::delete('/donasi-wakaf/{id}', [AdminDashboardController::class, 'donasiDestroy'])->name('donasi.destroy');

        // 3. Dokumen TU
        Route::get('/dokumen-tu', [AdminDashboardController::class, 'dokumenIndex'])->name('dokumen.index');
        Route::post('/dokumen-tu/{id}/status', [AdminDashboardController::class, 'dokumenUpdateStatus'])->name('dokumen.status');

        // 4. Kajian & Materi
        Route::get('/kajian-materi', [AdminDashboardController::class, 'kajianIndex'])->name('kajian.index');
        Route::post('/kajian-materi', [AdminDashboardController::class, 'kajianStore'])->name('kajian.store');
        Route::put('/kajian-materi/{id}', [AdminDashboardController::class, 'kajianUpdate'])->name('kajian.update');
        Route::delete('/kajian-materi/{id}', [AdminDashboardController::class, 'kajianDestroy'])->name('kajian.destroy');

        // 5. Tanya Ustaz
        Route::get('/tanya-ustaz', [AdminDashboardController::class, 'tanyaUstazIndex'])->name('tanya-ustaz.index');
        Route::post('/tanya-ustaz/{id}/jawab', [AdminDashboardController::class, 'tanyaUstazAnswer'])->name('tanya-ustaz.answer');
    });
});
