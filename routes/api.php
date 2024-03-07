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

    //user
    Route::get('user',  function (Request $request) {
        return $request->user();
    });

    //pengaduan
    Route::get('get_pengaduan', [PengaduanController::class, 'GetPengaduan']);

    //kategori pengaduan 
    Route::get('get_kategori_pengaduan', [KategoriPengaduan::class, 'GetKategoriPengaduan']);

    //indikator mutu
    Route::get('get_indikator_mutu', [IndikatorMutuController::class, 'GetIndikatorMutu']);
    Route::get('get_indikator_mutu_yajra', [IndikatorMutuController::class, 'GetIndikatorMutuYajra']);
    Route::post('store_indikator_mutu', [IndikatorMutuController::class, 'StoreIndikatorMutu']);
    Route::put('update_indikator_mutu/{id}', [IndikatorMutuController::class, 'UpdateIndikatorMutu']);

    //indikator mutu
    Route::get('get_detail_pengaduan', [DetailPengaduanController::class, 'GetDetailPengaduan']);

}); 