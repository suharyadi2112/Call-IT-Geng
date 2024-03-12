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
Route::get('check_valid_token', [SanctumAuthController::class, 'CheckValidToken']);

Route::middleware(['auth:sanctum'])->group(function () {

    //logout
    Route::post('logout', [SanctumAuthController::class, 'logout']);

    //user
    // Route::get('get_user',  function (Request $request) {
    //     return $request->user();
    // });
    Route::get('get_user', [SanctumAuthController::class, 'GetUsers']);
    Route::get('get_user_yajra', [SanctumAuthController::class, 'GetUsersYajra']);
    Route::get('get_user/{id}', [SanctumAuthController::class, 'GetUsersByID']);
    Route::get('get_user_list', [SanctumAuthController::class, 'GetUserList']);
    Route::post('store_user', [SanctumAuthController::class, 'StoreUser']);
    Route::delete('del_user/{id}', [SanctumAuthController::class, 'DelUser']);
    Route::put('change_password/{id}', [SanctumAuthController::class, 'ChangePasswordUser']);
    Route::put('reset_password/{id}', [SanctumAuthController::class, 'ResetPassword']);
    Route::put('update_user/{id}', [SanctumAuthController::class, 'UpdateUser']);
    
    //pengaduan
    Route::get('get_pengaduan', [PengaduanController::class, 'GetPengaduan']);
    Route::get('get_pengaduan_yajra', [PengaduanController::class, 'GetPengaduanYajra']);
    Route::get('get_pengaduan_list', [PengaduanController::class, 'GetPengaduanList']);
    Route::get('get_pengaduan/{id}', [PengaduanController::class, 'GetPengaduanByID']);
    Route::post('store_pengaduan', [PengaduanController::class, 'StorePengaduan']);
    Route::put('update_pengaduan/{id}', [PengaduanController::class, 'UpdatePengaduan']);
    Route::put('update_status_pengaduan/{id}', [PengaduanController::class, 'UpdateStatusPengaduan']);
    Route::put('assign_worker_to_pengaduan/{id}', [PengaduanController::class, 'AssignWorkerToPengaduan']);
    Route::delete('del_worker_from_pengaduan/{id_peng}/{id_worker}', [PengaduanController::class, 'DelWorkerFromPengaduan']);
    Route::post('store_picture_post_pengaduan/{id}', [PengaduanController::class, 'StorePicturePost']);


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
