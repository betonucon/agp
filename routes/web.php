<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LogoutController;
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


Route::group(['prefix' => 'barang'],function(){
    Route::get('/',[BarangController::class, 'index']);
    Route::get('/view',[BarangController::class, 'view_data']);
    Route::get('/getdata',[BarangController::class, 'get_data']);
    Route::get('/delete_data',[BarangController::class, 'delete_data']);
    Route::get('/create',[BarangController::class, 'create']);
    Route::get('/modal',[BarangController::class, 'modal']);
    Route::post('/',[BarangController::class, 'store']);
    Route::post('/import',[BarangController::class, 'import']);
});
Route::group(['middleware' => 'auth'], function() {
    /**
    * Logout Route
    */
    Route::get('/logout-perform', [LogoutController::class, 'perform'])->name('logout.perform');
 });
Route::group(['prefix' => 'sales','middleware'    => 'auth'],function(){
    Route::get('/',[SalesController::class, 'index']);
    Route::get('/view',[SalesController::class, 'view_data']);
    Route::get('/getdata',[SalesController::class, 'get_data']);
    Route::get('/buatuser',[SalesController::class, 'buat_user']);
    Route::get('/delete_data',[SalesController::class, 'delete_data']);
    Route::get('/create',[SalesController::class, 'create']);
    Route::get('/modal',[SalesController::class, 'modal']);
    Route::post('/',[SalesController::class, 'store']);
    Route::post('/import',[SalesController::class, 'import']);
});

Route::group(['prefix' => 'customer','middleware'    => 'auth'],function(){
    Route::get('/',[CustomerController::class, 'index']);
    Route::get('/view',[CustomerController::class, 'view_data']);
    Route::get('/getdata',[CustomerController::class, 'get_data']);
    Route::get('/delete_data',[CustomerController::class, 'delete_data']);
    Route::get('/create',[CustomerController::class, 'create']);
    Route::get('/modal',[CustomerController::class, 'modal']);
    Route::post('/',[CustomerController::class, 'store']);
    Route::post('/import',[CustomerController::class, 'import']);
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