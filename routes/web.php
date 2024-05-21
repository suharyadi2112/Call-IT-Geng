<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
// use App\Http\Controllers\Dashboard\IndikatorMutuController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PengaduanController;
use App\Http\Controllers\Dashboard\KategoriPengaduanController;
use App\Http\Controllers\Dashboard\IndikatorMutuController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\OncallController;
use App\Http\Controllers\Dashboard\PenggunaController;
use App\Http\Controllers\Dashboard\PesanMasukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanIndikatorMutuController;
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
        Route::get('/{id}/hapus', [PengaduanController::class, 'hapusPengaduan'])->middleware('adminRole')->name('pengaduan.delete');
    });


    Route::prefix('kategori')->middleware('adminRole')->group(function () {
        Route::get('/', [KategoriPengaduanController::class, 'kategori'])->name('kategori.index');
        Route::post('/store', [KategoriPengaduanController::class, 'storekategori'])->name('kategori.store');
        Route::get('/show/{id}', [KategoriPengaduanController::class, 'showkategori'])->name('kategori.show');
        Route::post('/update', [KategoriPengaduanController::class, 'updatekategori'])->name('kategori.update');
        Route::get('/{id}/hapus', [KategoriPengaduanController::class, 'destroykategori'])->name('kategori.destroy');
    });

    Route::prefix('laporan')->middleware('adminRole')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/get', [LaporanController::class, 'getlaporan'])->name('laporan.get');
        // Route::get('/export_excel', [LaporanController::class, 'export_excel'])->name('laporan.export');
        // Route::get('/siswa/export_excel', 'SiswaController@export_excel');

        // Route::post('/store', [PengaduanController::class, 'storekategori'])->name('kategori.store');
        // Route::get('/show/{id}', [PengaduanController::class, 'showkategori'])->name('kategori.show');
        // Route::post('/update', [PengaduanController::class, 'updatekategori'])->name('kategori.update');
        // Route::get('/hapus/{id}', [PengaduanController::class, 'destroykategori'])->name('kategori.destroy');
    });

    Route::prefix('pengguna')->middleware('adminRole')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/buat', [PenggunaController::class, 'create'])->name('pengguna.create');
        Route::post('/buat', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('/{id}', [PenggunaController::class, 'show'])->name('pengguna.show');
        Route::put('/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
        Route::get('/{id}/hapus', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    });

    Route::prefix('indikatormutu')->middleware('adminRole')->group(function () {
        Route::get('/', [IndikatorMutuController::class, 'index'])->name('indikatormutu.index');
        Route::post('/store', [IndikatorMutuController::class, 'store'])->name('indikatormutu.store');
        Route::get('/show/{id}', [IndikatorMutuController::class, 'showindikator'])->name('indikatormutu.index.show');
        Route::post('/update', [IndikatorMutuController::class, 'updateindikator'])->name('indikatormutu.update');
        Route::get('/hapus/{id}', [IndikatorMutuController::class, 'destroyindikator'])->name('indikatormutu.destroy');
    });

    Route::prefix('laporanindikatormutu')->middleware('adminRole')->group(function () {
        Route::get('/', [LaporanIndikatorMutuController::class, 'index'])->name('laporanindikatormutu.index');
        Route::post('/get', [LaporanIndikatorMutuController::class, 'getlaporan'])->name('laporanindikatormutu.get');
    });


    Route::prefix('jadwal-oncall')->middleware('adminRole')->group(function () {
        Route::get('/', [OncallController::class, 'index'])->name('jadwal-oncall.index');
        Route::get('/get-oncall', [OncallController::class, 'getOncall'])->name('jadwal-oncall.get');
        Route::post('/', [OncallController::class, 'store'])->name('jadwal-oncall.store');
    });


    Route::prefix('pesan-masuk')->middleware('adminRole')->group(function () {
        Route::get('/', [PesanMasukController::class, 'index'])->name('pesan-masuk.index');
        Route::get('/detail', [PesanMasukController::class, 'detail'])->name('pesan-masuk.detail');
    });
});


Route::get('/', function () { return view('frontend.welcome'); });
Route::get('/tentang', function () { return view('frontend.tentang'); });
Route::get('/kebijakan-privasi', function () { return view('frontend.kebijakan-privasi'); });
Route::get('/pertanyaan-umum', function () { return view('frontend.pertanyaan-umum'); });
Route::get('/syarat-ketentuan', function () { return view('frontend.syarat-ketentuan'); });

Route::get('pusher-test', [Controller::class, 'TangkapEvent']);
