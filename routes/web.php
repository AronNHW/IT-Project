<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengurus\AspirasiController;
use App\Http\Controllers\AspirasiUserController;
use App\Http\Controllers\Pengurus\BeritaController;
use App\Http\Controllers\Pengurus\DashboardController;
use App\Http\Controllers\UserBeritaController;
use App\Http\Controllers\Admin\AspirasiController as AdminAspirasiController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PrestasiController as AdminPrestasiController;
use App\Http\Controllers\Admin\AnggotaController as AdminAnggotaController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\UserPrestasiController;
use App\Http\Controllers\Pengurus\PrestasiController;
use App\Http\Controllers\Pengurus\AnggotaController;
use App\Http\Controllers\Pengurus\DivisiController as PengurusDivisiController;
use App\Http\Controllers\UserPendaftaranController;
use App\Http\Controllers\UserDivisiController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Pengurus\UserController as PengurusUserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Admin\PengaturanController as AdminPengaturanController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Pengurus\PengaturanController;


Route::get('/', function () {
    return view('welcome');
});

// --- AWAL PENAMBAHAN ROUTE OTENTIKASI ---

// Route untuk menampilkan halaman login
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');

// Route untuk memproses data login
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

// Route untuk menampilkan halaman registrasi
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegistrationForm'])->name('register');

// Route untuk memproses data registrasi
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

// Route untuk logout
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// --- AKHIR PENAMBAHAN ROUTE OTENTIKASI ---

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('aspirasi/print', [AdminAspirasiController::class, 'printPdf'])->name('aspirasi.printPdf');
    Route::resource('aspirasi', AdminAspirasiController::class)->only(['index', 'show', 'destroy']);
    Route::resource('berita', AdminBeritaController::class);
    Route::resource('prestasi', AdminPrestasiController::class);
    Route::resource('anggota', AdminAnggotaController::class);
    Route::resource('divisi', DivisiController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('mahasiswa-bermasalah', AdminPengaduanController::class)->except([]);

    Route::get('/kelola-anggota-himati', [AdminAnggotaController::class, 'kelolaAnggotaHimati'])->name('kelola-anggota-himati.index');
    Route::get('/anggota-per-divisi/{divisi}', [AdminAnggotaController::class, 'anggotaPerDivisi'])->name('anggota.per.divisi');
    Route::get('/calon-anggota', [AdminAnggotaController::class, 'calonAnggota'])->name('calon-anggota.index');
    Route::post('calon-anggota/{pendaftaran}/approve', [AdminAnggotaController::class, 'approveCandidate'])->name('calon-anggota.approve');
    Route::post('calon-anggota/{pendaftaran}/reject', [AdminAnggotaController::class, 'rejectCandidate'])->name('calon-anggota.reject');
    Route::get('/calon-anggota-tahap-1', [AdminAnggotaController::class, 'calonAnggotaTahap1'])->name('calon-anggota-tahap-1.index');
    Route::get('/calon-anggota-tahap-2', [AdminAnggotaController::class, 'calonAnggotaTahap2'])->name('calon-anggota-tahap-2.index');
    Route::post('calon-anggota/{pendaftaran}/pass-interview', [AdminAnggotaController::class, 'passInterview'])->name('calon-anggota.pass-interview');
    Route::post('calon-anggota/{pendaftaran}/fail-interview', [AdminAnggotaController::class, 'failInterview'])->name('calon-anggota.fail-interview');
    Route::delete('/calon-anggota/{anggotum}', [AdminAnggotaController::class, 'destroy'])->name('calon-anggota.destroy');

    Route::get('/pengaturan/wa', [AdminPengaturanController::class, 'waSetting'])->name('pengaturan.wa.setting');
    Route::put('/pengaturan/wa', [AdminPengaturanController::class, 'waUpdate'])->name('pengaturan.wa.update');
    Route::get('/setting', [AdminSettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [AdminSettingController::class, 'store'])->name('setting.store');
    Route::post('/setting/profile', [AdminSettingController::class, 'updateProfile'])->name('setting.profile.update');
})
;

Route::prefix('pengurus')->name('pengurus.')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('aspirasi/print', [AspirasiController::class, 'printPdf'])->name('aspirasi.printPdf');
  Route::resource('aspirasi', AspirasiController::class)->only(['index', 'show', 'destroy']);
  Route::resource('berita', BeritaController::class);
  Route::resource('prestasi', PrestasiController::class);
  Route::resource('divisi', PengurusDivisiController::class);
  Route::resource('users', PengurusUserController::class);

        Route::resource('anggota', AnggotaController::class)->except(['create', 'store', 'edit']);
        Route::get('calon-anggota', [AnggotaController::class, 'calonAnggota'])->name('calon-anggota.index');
        Route::post('calon-anggota/{pendaftaran}/approve', [AnggotaController::class, 'approveCandidate'])->name('calon-anggota.approve');
        Route::post('calon-anggota/{pendaftaran}/reject', [AnggotaController::class, 'rejectCandidate'])->name('calon-anggota.reject');
        Route::get('calon-anggota-tahap-1', [AnggotaController::class, 'calonAnggotaTahap1'])->name('calon-anggota-tahap-1.index');
        Route::get('calon-anggota-tahap-2', [AnggotaController::class, 'calonAnggotaTahap2'])->name('calon-anggota-tahap-2.index');
        Route::post('calon-anggota/{pendaftaran}/approve-stage-2', [AdminAnggotaController::class, 'approveCandidateStage2'])->name('calon-anggota.approve-stage-2');
        Route::post('calon-anggota/{pendaftaran}/reject-stage-2', [AdminAnggotaController::class, 'rejectCandidateStage2'])->name('calon-anggota.reject-stage-2');
        Route::post('calon-anggota/{pendaftaran}/pass-interview', [AdminAnggotaController::class, 'passInterview'])->name('calon-anggota.pass-interview');
        Route::get('kelola-anggota-himati', [AnggotaController::class, 'kelolaAnggotaHimati'])->name('kelola-anggota-himati.index');
        Route::get('anggota-per-divisi/{divisi}', [AnggotaController::class, 'anggotaPerDivisi'])->name('anggota.per.divisi');

  Route::delete('/calon-anggota/{anggotum}', [AnggotaController::class, 'destroy'])->name('calon-anggota.destroy');

    Route::get('/pengaturan/wa', [PengaturanController::class, 'waSetting'])->name('pengaturan.wa.setting');
    Route::put('/pengaturan/wa', [PengaturanController::class, 'waUpdate'])->name('pengaturan.wa.update');
});

Route::prefix('user')->name('user.')->group(function () {
    Route::view('/beranda', 'user.beranda')->name('beranda');
    Route::get('/divisi', [UserDivisiController::class, 'index'])->name('divisi');
    Route::get('/divisi/{divisi}', [UserDivisiController::class, 'show'])->name('divisi.show');
    Route::get('/profil', [UserProfileController::class, 'showProfile'])->name('profil');
    Route::get('/profil/pengaturan', [UserProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/pengaturan', [UserProfileController::class, 'update'])->name('profil.update');
    Route::get('/berita', [UserBeritaController::class, 'index'])->name('berita');
    Route::get('/berita/{berita}', [UserBeritaController::class, 'show'])->name('berita.show');
    Route::post('/berita/{berita}/komentar', [UserBeritaController::class, 'storeKomentar'])->name('komentar.store');
    Route::get('/pendaftaran', [UserPendaftaranController::class, 'showPendaftaranForm'])->name('pendaftaran');
    Route::post('/pendaftaran', [UserPendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/prestasi', [UserPrestasiController::class, 'index'])->name('prestasi');
    Route::view('/aspirasi', 'user.aspirasi')->name('aspirasi');
    Route::post('/aspirasi', [AspirasiUserController::class, 'store'])->name('aspirasi.store');
    Route::view('/bermasalah', 'user.bermasalah')->name('bermasalah');
    Route::post('/bermasalah', [\App\Http\Controllers\Admin\PengaduanController::class, 'store'])->name('bermasalah.store');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);