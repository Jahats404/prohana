<?php

use App\Http\Controllers\agen\pesanan\PesananController as PesananAgenController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\produsen\pengiriman\PengirimanController;
use App\Http\Controllers\Produsen\akun\AgenController;
use App\Http\Controllers\produsen\akun\DistributorController;
use App\Http\Controllers\produsen\pesanan\PesananController as PesananProdusenController;
use App\Http\Controllers\produsen\produk\ProdukController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('produsen.dashboard');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});

route::get('/login', [AuthController::class,'login'])->name('login');
route::post('/authenticate', [AuthController::class,'authenticate'])->name('authenticate');
route::post('/logout', [AuthController::class,'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {


    // Route prefix untuk Produsen

    Route::prefix('produsen')->name('produsen.')->middleware('CekUserLogin:1')->group(function () {

        //DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'dashboardP'])->name('dashboard');

        // KELOLA DISTRIBUTOR
        Route::get('/distributor', [DistributorController::class, 'index'])->name('kelola-distributor');
        Route::post('/distributor', [DistributorController::class, 'store'])->name('store-distributor');
        Route::put('/distributor/{id}', [DistributorController::class, 'update'])->name('update-distributor');
        Route::delete('/distributor/{id}', [DistributorController::class, 'destroy'])->name('delete-distributor');

        // KELOLA PRODUK
        Route::get('/produk', [ProdukController::class, 'index'])->name('kelola-produk');
        Route::post('/produk', [ProdukController::class,'store'])->name('store-produk');
        Route::put('/produk/{id}', [ProdukController::class,'update'])->name('edit-produk');
        Route::delete('/produk/{id}', [ProdukController::class,'destroy'])->name('delete-produk');

        // Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('hapus-produk');


        // KELOLA AGEN
        Route::get('/agen', [AgenController::class, 'index'])->name('kelola-agen');
        Route::post('/agen', [AgenController::class, 'store'])->name('store-agen');
        Route::put('/agen/{id}', [AgenController::class, 'update'])->name('update-agen');
        Route::delete('/agen/{id}', [AgenController::class, 'destroy'])->name('delete-agen');

        // KELOLA PESANAN
        Route::get('pesanan', [PesananProdusenController::class, 'index'])->name('kelola-pesanan');
        // Route::post('pesanan/store', [PesananProdusenController::class, 'store'])->name('pesanan.store');
        // Route::put('pesanan/update/{id}', [PesananProdusenController::class, 'update'])->name('pesanan.update');
        // Route::delete('pesanan/destroy/{id}', [PesananProdusenController::class, 'destroy'])->name('pesanan.destroy');
        // Route::put('pesanan/status/{id}', [PesananProdusenController::class, 'status'])->name('pesanan.status');

        // KELOLA DISTRIBUSI
        Route::get('pengiriman', [PengirimanController::class, 'index'])->name('kelola-pengiriman');

        // Route::put('distribusi/update/{id}', [DistribusiController::class, 'update'])->name('distribusi.update');

        // KELOLA GARANSI
        // Route::get('garansi', [GaransiController::class, 'index'])->name('garansi.index');
        // Route::post('garansi/store', [GaransiController::class, 'store'])->name('garansi.store');
        // Route::delete('garansi/destroy/{id}', [GaransiController::class, 'destroy'])->name('garansi.destroy');
        // Route::put('garansi/update/{id}', [GaransiController::class, 'update'])->name('garansi.update');

    });

    // Route prefix untuk Distributor
    Route::prefix('distributor')->name('distributor.')->middleware('CekUserLogin:2')->group(function () {

        //DASHBOARD DISTRIBUTOR
        Route::get('/dashboard', [DashboardController::class, 'dashboardD'])->name('dashboard');


        // Route::get('/distributor', [DistributorController::class, 'distributor'])->name('distributor');
        // Route::put('/distributor/update/{id}', [DistributorController::class, 'update'])->name('distributor.update');
        // Route::delete('/distributor/destroy/{id}', [DistributorController::class, 'destroy'])->name('distributor.destroy');


        // Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
        // Route::post('/tambah-produk', [ProdukController::class,'store'])->name('tambah-produk');
        // Route::put('/edit-produk/{id}', [ProdukController::class,'update'])->name('edit-produk');
        // Route::delete('/hapus-produk/{id}', [ProdukController::class,'destroy'])->name('hapus-produk');

    });


    // Route prefix untuk AGEN
    Route::prefix('agen')->name('agen.')->middleware('CekUserLogin:3')->group(function () {

        //DASHBOARD AGEN
        Route::get('/dashboard', [DashboardController::class, 'dashboardA'])->name('dashboard');
        Route::get('/pesanan', [PesananAgenController::class, 'index'])->name('pesanan');
        Route::post('/pesanan', [PesananAgenController::class, 'store'])->name('store-pesanan');

        // Route::get('/dashboard', [AgenController::class, 'dashboard'])->name('dashboard');
        // Route::get('/produk', [AgenProdukController::class, 'index'])->name('produk');


        // Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
        // Route::post('/tambah-produk', [ProdukController::class,'store'])->name('tambah-produk');
        // Route::put('/edit-produk/{id}', [ProdukController::class,'update'])->name('edit-produk');
        // Route::delete('/hapus-produk/{id}', [ProdukController::class,'destroy'])->name('hapus-produk');

    });
});
