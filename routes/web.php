<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
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


Route::group(['prefix' => 'barang','middleware'    => 'auth'],function(){
    Route::get('/',[BarangController::class, 'index']);
    Route::get('/getdata',[BarangController::class, 'get_data']);
    Route::get('/delete_data',[BarangController::class, 'delete_data']);
    Route::get('/create',[BarangController::class, 'create']);
    Route::get('/modal',[BarangController::class, 'modal']);
    Route::post('/',[BarangController::class, 'store']);
    Route::post('/import',[BarangController::class, 'import']);
});
Route::group(['prefix' => 'user'],function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create', [UserController::class, 'create']);
    Route::get('/get_data', [UserController::class, 'get_data']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
