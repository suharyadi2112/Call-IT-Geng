<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PengaduanController;
use App\Http\Controllers\Controller;
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

    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('pengaduan/buat', function () {
        return view('dashboard.pengaduan.pengaduan_create');
    })->name('pengaduan.index.create');
    
    Route::get('kategori', [PengaduanController::class, 'kategori'])->name('pengaduan.kategori');
    Route::post('kategori/store', [PengaduanController::class, 'storekategori'])->name('pengaduan.kategori.store');
    Route::get('kategori/hapus/{id}', [PengaduanController::class, 'destroykategori'])->name('pengaduan.kategori.destroy');
    

    // //indikatormutu
    Route::get('indikatormutu', [IndikatorMutuController::class, 'index'])->name('indikatormutu.index');
    // Route::get('indikatormutu/tambah', [IndikatorMutuController::class, 'create'])->name('indikatormutu.create');
    // Route::post('indikatormutu/store', [IndikatorMutuController::class, 'store'])->name('indikatormutu.store');
});



Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Route::get('pusher-test', [Controller::class, 'TangkapEvent']);