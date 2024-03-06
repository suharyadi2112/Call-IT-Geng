<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SanctumAuthController;
use App\Http\Controllers\Api\KategoriPengaduan\KategoriPengaduan;


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


    //kategori pengaduan 
    Route::get('get_kategori_pengaduan', [KategoriPengaduan::class, 'GetKategoriPengaduan']);
});