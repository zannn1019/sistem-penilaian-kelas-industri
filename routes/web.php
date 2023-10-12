<?php

use App\Http\Controllers\AdminPengajarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TugasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome', ['title' => 'Sistem Penilaian Kelas Industri']);
});


Route::get('/forgotPassword', [UserController::class, 'forgotpass'])->middleware('guest')->name('forgot-password');
Route::post('/forgot-password', [UserController::class, 'forgotpass_email'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [UserController::class, 'resetform'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [UserController::class, 'resetpass'])->middleware('guest')->name('password.update');

Route::resource('/login', UserController::class)->middleware('guest')->name('index', 'login');
Route::post('/login', [UserController::class, 'auth'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

//*Route Pengajar
Route::middleware(['auth', 'user:pengajar'])->group(function () {
    Route::prefix('/pengajar')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-pengajar');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile-pengajar');
        Route::get('/kelas', [DashboardController::class, 'kelas'])->name('kelas-pengajar');
        Route::get('/kelas/{kelas}', [DashboardController::class, 'selectMapel'])->name('select-mapel');
        Route::get('/kelas/{kelas}/tugas/{tugas}/nilai', [DashboardController::class, 'inputNilai'])->name('input-nilai');
        Route::get('/kelas/{kelas}/siswa', [DashboardController::class, 'showSiswa'])->name('show-siswa');
        Route::get('/kelas/{kelas}/nilai', [DashboardController::class, 'showNilaiPerKelas'])->name('show-nilai-perkelas');
        Route::get('/kelas/{kelas}/siswa/{siswa}', [DashboardController::class, 'detailSiswa'])->name('detail-siswa');
        Route::controller(TugasController::class)->group(function () {
            Route::get('/kelas/{kelas}/mapel/{mapel}', 'index')->name('tugas.index');
            Route::get('/kelas/{kelas}/mapel/{mapel}/nilai', 'showNilai')->name('tugas.shownilai');
            Route::post('/tugas', 'store')->name('tugas.store');
        });
        Route::resource('/nilai', NilaiController::class)->names('nilai');
    });
});

//*Route Admin
Route::middleware(['auth', 'user:admin'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/profile', function () {
            return view('dashboard.admin.pages.profile', [
                'title' => "Profile",
                'full' => true
            ]);
        })->name('profile-admin');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-admin');
        Route::resource('/sekolah', SekolahController::class)->names('sekolah');
        Route::get('/sekolah/{sekolah}/{data}', [SekolahController::class, 'maximize'])->name('sekolah.maximize');
        Route::resource('/kelas', KelasController::class)->names('kelas');
        Route::resource('/pengajar', PengajarController::class)->names('pengajar');
        Route::resource('/siswa', SiswaController::class)->names('siswa');
        Route::resource('user', UserController::class)->names('users');
        Route::resource('/mapel', MapelController::class)->names('mapel');
        Route::get('/nilai', [NilaiController::class, 'index'])->name('getNilai');
        Route::controller(AdminPengajarController::class)->group(function () {
            Route::prefix('/pengajarDashboard/{pengajar}')->group(function () {
                Route::get('/', 'index')->name('admin-dashboard-pengajar');
                Route::get('/kelas', 'kelas')->name('admin-kelas-pengajar');
                Route::get('/kelas/{kelas}/raport', 'raporKelas')->name('admin-raport-kelas-pengajar');
                Route::get('/kelas/{kelas}', 'showMapel')->name('admin-show-mapel-pengajar');
                Route::get('/kelas/{kelas}/siswa', 'showSiswa')->name('admin-show-siswa-pengajar');
                Route::get('/kelas/{kelas}/pengajar', 'showPengajar')->name('admin-show-pengajar-pengajar');
                Route::get('/kelas/{kelas}/mapel/{mapel}', 'showTugas')->name('admin-show-tugas-pengajar');
                Route::get('/kelas/{kelas}/mapel/{mapel}/nilai', 'showNilai')->name('admin-show-nilai-pengajar');
                Route::get('/kelas/{kelas}/tugas/{tugas}', 'nilaiSiswaPerKelas')->name('admin-show-nilai-pertugas-pengajar');
                Route::get('/kelas/{kelas}/siswa/{siswa}', 'detailSiswa')->name('admin-detail-siswa-pengajar');
            });
        });
    });
});

Route::controller(ExportController::class)->group(function () {
    Route::get('/export/kelas/{kelas}', 'ExportPerKelas')->name('ExportPerKelas');
    Route::get('/export/siswa/{siswa}', 'ExportPerSiswa')->name('ExportPerSiswa');
    Route::get('/export/kelas/{kelas}/mapel/{mapel}', 'ExportPerTugas')->name('ExportPerTugas');
});
