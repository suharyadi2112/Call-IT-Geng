<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
// use App\Http\Controllers\Dashboard\IndikatorMutuController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PengaduanController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\PenggunaController;
use App\Http\Controllers\LaporanController;
use App\Models\Pengaduan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/loginx', function () { 
    return response()->json('Authentication failed:'); 
})->name('loginX');


// Routes Authentication
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'postLogin'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');



// Routes Dashboard
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profil', [ProfileController::class, 'index'])->name('profil.index');
    Route::post('profil', [ProfileController::class, 'update'])->name('profil.update');

    Route::prefix('pengaduan')->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('/buat', [PengaduanController::class, 'buatPengaduan'])->name('pengaduan.create');
        Route::post('/buat', [PengaduanController::class, 'simpanPengaduan'])->name('pengaduan.store');
        Route::get('/{id}', [PengaduanController::class, 'detailPengaduan'])->name('pengaduan.detail');
        Route::put('/{id}', [PengaduanController::class, 'updatePengaduan'])->name('pengaduan.update');
        Route::get('/{id}/hapus', [PengaduanController::class, 'hapusPengaduan'])->middleware('checkRole')->name('pengaduan.delete');
    });
    

    Route::prefix('kategori')->middleware('checkRole')->group(function () {
        Route::get('/', [PengaduanController::class, 'kategori'])->name('kategori.index');
        Route::post('/store', [PengaduanController::class, 'storekategori'])->name('kategori.store');
        Route::get('/show/{id}', [PengaduanController::class, 'showkategori'])->name('kategori.show');
        Route::post('/update', [PengaduanController::class, 'updatekategori'])->name('kategori.update');
        Route::get('/hapus/{id}', [PengaduanController::class, 'destroykategori'])->name('kategori.destroy');
    });

    Route::prefix('laporan')->middleware('checkRole')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/get', [LaporanController::class, 'getlaporan'])->name('laporan.get');
        // Route::get('/export_excel', [LaporanController::class, 'export_excel'])->name('laporan.export');
        // Route::get('/siswa/export_excel', 'SiswaController@export_excel');

        // Route::post('/store', [PengaduanController::class, 'storekategori'])->name('kategori.store');
        // Route::get('/show/{id}', [PengaduanController::class, 'showkategori'])->name('kategori.show');
        // Route::post('/update', [PengaduanController::class, 'updatekategori'])->name('kategori.update');
        // Route::get('/hapus/{id}', [PengaduanController::class, 'destroykategori'])->name('kategori.destroy');
    });
    
    Route::prefix('pengguna')->middleware('checkRole')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/buat', [PenggunaController::class, 'create'])->name('pengguna.create');
        Route::post('/buat', [PenggunaController::class,'store'])->name('pengguna.store');
        Route::get('/{id}', [PenggunaController::class, 'show'])->name('pengguna.show');
        Route::put('/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
        Route::get('/{id}/hapus', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    });
    

});



Route::get('/', function () {
    return redirect('/login');
});

Route::get('pusher-test', [Controller::class, 'TangkapEvent']);