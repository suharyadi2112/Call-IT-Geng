<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SanctumAuthController;
use App\Http\Controllers\Api\KategoriPengaduan\KategoriPengaduan;
use App\Http\Controllers\Api\IndikatorMutu\IndikatorMutuController;
use App\Http\Controllers\Api\DetailPengaduan\DetailPengaduanController;
use App\Http\Controllers\Api\Pengaduan\PengaduanController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [SanctumAuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    //logout
    Route::post('logout', [SanctumAuthController::class, 'logout']);

    //user
    // Route::get('get_user',  function (Request $request) {
    //     return $request->user();
    // });
    Route::get('get_user', [SanctumAuthController::class, 'GetUsers']);
    Route::get('get_user_yajra', [SanctumAuthController::class, 'GetUsersYajra']);

    //pengaduan
    Route::get('get_pengaduan', [PengaduanController::class, 'GetPengaduan']);

    //kategori pengaduan 
    Route::get('get_kategori_pengaduan', [KategoriPengaduan::class, 'GetKategoriPengaduan']);
    Route::get('get_kategori_pengaduan_yajra', [KategoriPengaduan::class, 'GetKategoriPengaduanYajra']);
    Route::get('get_kategori_pengaduan_list', [KategoriPengaduan::class, 'GetKategoriPengaduanList']);
    Route::get('get_kategori_pengaduan/{id}', [KategoriPengaduan::class, 'GetKategoriPengaduanByID']);
    Route::post('store_kategori_pengaduan', [KategoriPengaduan::class, 'StoreKategoriPengaduan']);
    Route::delete('del_kategori_pengaduan/{id}', [KategoriPengaduan::class, 'DelKategoriPengaduan']);
    Route::put('update_kategori_pengaduan/{id}', [KategoriPengaduan::class, 'UpdateKategoriPengaduan']);

    //indikator mutu
    Route::get('get_indikator_mutu', [IndikatorMutuController::class, 'GetIndikatorMutu']);
    Route::get('get_indikator_mutu_list', [IndikatorMutuController::class, 'GetIndikatorMutuList']);
    Route::get('get_indikator_mutu_yajra', [IndikatorMutuController::class, 'GetIndikatorMutuYajra']);
    Route::get('get_indikator_mutu/{id}', [IndikatorMutuController::class, 'GetIndikatorMutuByID']);
    Route::post('store_indikator_mutu', [IndikatorMutuController::class, 'StoreIndikatorMutu']);
    Route::put('update_indikator_mutu/{id}', [IndikatorMutuController::class, 'UpdateIndikatorMutu']);
    Route::delete('del_indikator_mutu/{id}', [IndikatorMutuController::class, 'DelIndikatorMutu']);
    

    //detail pengaduan
    Route::get('get_detail_pengaduan', [DetailPengaduanController::class, 'GetDetailPengaduan']);
    

}); 