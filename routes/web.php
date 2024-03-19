<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\IndikatorMutuController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PengaduanController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\PenggunaController;
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

    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/buat',[PengaduanController::class, 'buatPengaduan'])->name('pengaduan.index.create');
    Route::post('pengaduan/buat',[PengaduanController::class, 'simpanPengaduan'])->name('pengaduan.index.store');
    Route::get('pengaduan/{id}',[PengaduanController::class, 'detailPengaduan'])->name('pengaduan.index.detail');
    Route::put('pengaduan/{id}',[PengaduanController::class, 'updatePengaduan'])->name('pengaduan.index.update');
    Route::get('pengaduan/{id}/hapus',[PengaduanController::class, 'hapusPengaduan'])->name('pengaduan.index.delete');
    
    Route::get('kategori', [PengaduanController::class, 'kategori'])->name('pengaduan.kategori');
    Route::post('kategori/store', [PengaduanController::class, 'storekategori'])->name('pengaduan.kategori.store');
    Route::get('kategori/show/{id}', [PengaduanController::class, 'showkategori'])->name('pengaduan.kategori.show');
    Route::post('kategori/update', [PengaduanController::class, 'updatekategori'])->name('pengaduan.kategori.update');
    Route::get('kategori/hapus/{id}', [PengaduanController::class, 'destroykategori'])->name('pengaduan.kategori.destroy');
    
    Route::get('indikatormutu', [IndikatorMutuController::class, 'index'])->name('indikatormutu.index');
    Route::post('indikatormutu/store', [IndikatorMutuController::class, 'store'])->name('indikatormutu.store');
    Route::get('indikatormutu/show/{id}', [IndikatorMutuController::class, 'showindikator'])->name('indikatormutu.index.show');
    Route::post('indikatormutu/update', [IndikatorMutuController::class, 'updateindikator'])->name('indikatormutu.update');
    Route::get('indikatormutu/hapus/{id}', [IndikatorMutuController::class, 'destroyindikator'])->name('indikatormutu.destroy');

    Route::get('pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('pengguna/buat', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('pengguna/buat', [PenggunaController::class,'store'])->name('pengguna.store');
    Route::get('pengguna/{id}', [PenggunaController::class, 'show'])->name('pengguna.show');
    Route::put('pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

});



Route::get('/', function () {
    return redirect('/login');
});

Route::get('pusher-test', [Controller::class, 'TangkapEvent']);