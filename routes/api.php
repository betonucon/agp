<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\MasterController;
use App\Http\Controllers\Api\CustomerController;
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
Route::post('login', [AuthController::class, 'login']);
Route::post('customer/login', [AuthController::class, 'login_customer']);
Route::post('cek-login', [AuthController::class, 'cek_login']);
Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'barang','middleware'    => 'auth:sanctum'],function(){
    Route::get('/', [ProdukController::class, 'index']);
});
Route::group(['prefix' => 'master'],function(){
    Route::get('/provinsi', [MasterController::class, 'provinsi']);
    Route::get('/kategori_produk', [MasterController::class, 'kategori_produk']);
    Route::get('/kota/{Kd_Propinsi?}', [MasterController::class, 'kota']);
});
Route::group(['prefix' => 'customer','middleware'    => 'auth:sanctum'],function(){
    Route::get('/', [CustomerController::class, 'index']);
});
Route::post('register', [AuthController::class, 'register']);
