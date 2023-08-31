<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SiswaController;

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

Route::resource('/login', UserController::class)->middleware('guest')->name('index', 'login');
Route::post('/login', [UserController::class, 'auth'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

//*Route Pengajar
Route::middleware(['auth', 'user:pengajar'])->group(function () {
    Route::prefix('/pengajar')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-pengajar');
        Route::get('/nilai', [DashboardController::class, 'nilai'])->name('nilai');
        Route::resource('/kelas', KelasController::class)->names('kelas');
    });
});

//*Route Admin
Route::middleware(['auth', 'user:admin'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-admin');
        Route::resource('/sekolah', SekolahController::class)->names('sekolah');
        Route::resource('/kelas', KelasController::class)->names('kelas');
        Route::resource('/pengajar', PengajarController::class)->names('pengajar');
        Route::resource('/siswa', SiswaController::class)->names('siswa');
        Route::resource('user', UserController::class)->names('users');
        Route::resource('/mapel', MapelController::class)->names('mapel');
    });
});
