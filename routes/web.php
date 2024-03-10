<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PengaduanController;

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

Route::get('login', [LoginController::class, 'login'])->name('login.index');

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profil', [ProfileController::class, 'index'])->name('profil.index');

    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    
    Route::get('kategori', [PengaduanController::class, 'kategori'])->name('pengaduan.kategori');

    // //indikatormutu
    Route::get('indikatormutu', [IndikatorMutuController::class, 'index'])->name('indikatormutu.index');
    // Route::get('indikatormutu/tambah', [IndikatorMutuController::class, 'create'])->name('indikatormutu.create');
    // Route::post('indikatormutu/store', [IndikatorMutuController::class, 'store'])->name('indikatormutu.store');
});



Route::get('/', function () {
    return view('welcome');
});
