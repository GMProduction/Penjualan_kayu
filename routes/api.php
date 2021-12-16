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

Route::group(['prefix' => 'barang', 'middleware' => 'auth:api'], function () {
    Route::get('/', [\App\Http\Controllers\Api\BarangController::class, 'getList']);
});

Route::group(['prefix' => 'keranjang', 'middleware' => 'auth:api'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\Api\KeranjangController::class, 'index']);
    Route::post( '/checkout', [\App\Http\Controllers\Api\KeranjangController::class, 'checkout']);
});
