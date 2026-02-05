<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JenisSKController;
use App\Http\Controllers\PedomanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\UserGuideController;
use App\Http\Controllers\WasdalbinController;
use App\Http\Controllers\SuratAktifController;
use App\Http\Controllers\KepanitiaanController;
use App\Http\Controllers\SopAkademikController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\SkKepanitiaanController;
use App\Http\Controllers\SuratAkademikController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\LpjKepanitiaanController;
use App\Http\Controllers\RekapitulasiArsipController;
use App\Http\Controllers\UserGuideMahasiswaController;
use App\Http\Controllers\UserGuideTatausahaController;
use App\Http\Controllers\UserGuidePenggunaMahasiswaController;
use App\Http\Controllers\UserGuidePenggunaTatausahaController;


Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/loginproses', 'loginproses')->name('loginproses');
    Route::get('/register', 'register')->name('register');
    Route::post('/registerproses', 'registerproses')->name('registerproses');
    Route::get('/logout', 'logout')->name('logout');
});

Route::post('/suratAktif/pengajuan', [SuratAktifController::class, 'pengajuan'])->name('suratAktif.pengajuan');
Route::post('/suratAkademik/pengajuan', [SuratAkademikController::class, 'pengajuan'])->name('suratAkademik.pengajuan');
Route::get('/suratAktif/{suratAktif}/validasi', [SuratAktifController::class, 'validasi'])->name('suratAktif.validasi');
Route::get('/suratAktif/{suratAktif}/preview', [SuratAktifController::class, 'preview'])->name('suratAktif.preview');

Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('users', UserController::class);
    Route::get('/user/{id}/update-password', [UserController::class, 'showUpdatePasswordForm'])->name('users.showUpdatePasswordForm');
    Route::put('/user/{id}/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
    Route::resource('tahunAkademik', TahunAkademikController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('programStudi', ProgramStudiController::class);
    Route::resource('jenissk', JenisSKController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('dosen', DosenController::class);
    Route::resource('suratAktif', SuratAktifController::class);
    Route::resource('suratAkademik', SuratAkademikController::class);
    Route::resource('sopakademik', SopAkademikController::class);
    Route::resource('lpjkepanitiaan', LpjKepanitiaanController::class);
    Route::resource('pedoman', PedomanController::class);
    Route::resource('skkepanitiaan', SkKepanitiaanController::class);
    Route::resource('kurikulum', KurikulumController::class);
    Route::resource('wasdalbin', WasdalbinController::class);
    Route::resource('userGuide', UserGuideController::class);
    Route::resource('faq', FAQController::class);
    Route::get('/userguidepengguna', [FAQController::class, 'userguidepengguna'])->name('userguidepengguna');
    Route::resource('userGuideMahasiswa', UserGuideMahasiswaController::class);
    Route::get('userGuidePenggunaMahasiswa', [UserGuidePenggunaMahasiswaController::class, 'index'])->name('userGuidePenggunaMahasiswa');
    Route::resource('userGuideTatausaha', UserGuideTatausahaController::class);
    Route::get('userGuidePenggunaTatausaha', [UserGuidePenggunaTatausahaController::class, 'index'])->name('userGuidePenggunaTatausaha');
    Route::get('rekapitulasiarsip/export', [RekapitulasiArsipController::class, 'export'])->name('rekapitulasiarsip.export');
    Route::resource('rekapitulasiarsip', RekapitulasiArsipController::class);
});
