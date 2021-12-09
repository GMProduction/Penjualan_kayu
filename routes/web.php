<?php

use App\Http\Controllers\Admin\BanerController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\User\DikemasController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\MenungguController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\PengirimanController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SelesaiController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('admin.dashboard');
});


Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/admin', function () {
    return view('admin.admin');
});

Route::get('/admin/barang', function () {
    return view('admin.barang');
});

Route::get('/admin/transaksi', function () {
    return view('admin.transaksi');
});

Route::get('/admin/laporantransaksi', function () {
    return view('admin.laporantransaksi');
});

Route::get('/admin/laporanpemasukan', function () {
    return view('admin.laporanpemasukan');
});

Route::prefix('laporantransaksi')->group(
    function () {
        Route::get('/', [\App\Http\Controllers\Admin\TransaksiController::class, 'laporanTransaksi']);
        Route::get('/cetak', [\App\Http\Controllers\Admin\TransaksiController::class, 'cetak']);

    }
);

Route::prefix('laporanpemasukan')->group(
    function () {
        Route::get('/', [\App\Http\Controllers\Admin\PemasukanController::class, 'index']);
        Route::get('/cetak', [\App\Http\Controllers\Admin\PemasukanController::class, 'cetak']);
    }
);

Route::get('a/dmin/laporantransaksi/cetak', [LaporanController::class, 'cetakLaporanTransaksi']);
Route::get('/admin/laporanpemasukan/cetak', [LaporanController::class, 'cetakLaporanPemasukan']);

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register-member', [AuthController::class, 'registerMember']);
