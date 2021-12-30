<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [\App\Http\Controllers\Api\BarangController::class, 'getList']);
    Route::get('/{id}', [\App\Http\Controllers\Api\BarangController::class, 'detail']);
});

Route::group(['prefix' => 'keranjang', 'middleware' => 'auth:api'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\Api\KeranjangController::class, 'index']);
    Route::post('/checkout', [\App\Http\Controllers\Api\KeranjangController::class, 'checkout']);
    Route::post('/delete/{id}', [\App\Http\Controllers\Api\KeranjangController::class, 'delete']);
});

Route::group(['prefix' => 'transaksi', 'middleware' => 'auth:api'], function () {
    Route::get('/', [\App\Http\Controllers\Api\TransaksiController::class, 'index']);
    Route::match(['get', 'post'], '/{id}', [\App\Http\Controllers\Api\TransaksiController::class, 'detail']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'profil'], function () {
    Route::match(['get', 'post'],'/', [\App\Http\Controllers\Api\ProfileController::class, 'index']);
});


