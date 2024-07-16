<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\produsen\kelolaAkun\DistributorController;
use App\Http\Controllers\Produsen\KelolaAkun\KelolaAgenController;
use App\Http\Controllers\produsen\kelolaAkun\KelolaDistributorController;
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

        // // KELOLA DISTRIBUTOR
        Route::get('/distributor', [KelolaDistributorController::class, 'index'])->name('kelola-distributor');
        Route::post('/distributor', [KelolaDistributorController::class, 'store'])->name('store-distributor');
        Route::put('/distributor/{id}', [KelolaDistributorController::class, 'update'])->name('update-distributor');
        Route::delete('/distributor/{id}', [KelolaDistributorController::class, 'destroy'])->name('delete-distributor');

        // //KELOLA PRODUK
        // Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
        // Route::post('/tambah-produk', [ProdukController::class,'store'])->name('tambah-produk');
        // Route::put('/edit-produk/{id}', [ProdukController::class,'update'])->name('edit-produk');
        // // Route::delete('/hapus-produk/{id}', [ProdukController::class,'destroy'])->name('hapus-produk');

        // Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('hapus-produk');


        // //KELOLA AGEN
        Route::get('/agen', [KelolaAgenController::class, 'index'])->name('kelola-agen');
        Route::post('/agen', [KelolaAgenController::class, 'store'])->name('store-agen');
        Route::put('/agen/{id}', [KelolaAgenController::class, 'update'])->name('update-agen');
        Route::delete('/agen/{id}', [KelolaAgenController::class, 'destroy'])->name('delete-agen');

        // //KELOLA PESANAN
        // Route::get('pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        // Route::post('pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
        // Route::put('pesanan/update/{id}', [PesananController::class, 'update'])->name('pesanan.update');
        // Route::delete('pesanan/destroy/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
        // Route::put('pesanan/status/{id}', [PesananController::class, 'status'])->name('pesanan.status');

        // //KELOLA DISTRIBUSI
        // Route::get('distribusi', [DistribusiController::class, 'index'])->name('distribusi.index');

        // Route::put('distribusi/update/{id}', [DistribusiController::class, 'update'])->name('distribusi.update');

        // // KELOLA GARANSI
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

        // Route::get('/dashboard', [AgenController::class, 'dashboard'])->name('dashboard');
        // Route::get('/produk', [AgenProdukController::class, 'index'])->name('produk');


        // Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
        // Route::post('/tambah-produk', [ProdukController::class,'store'])->name('tambah-produk');
        // Route::put('/edit-produk/{id}', [ProdukController::class,'update'])->name('edit-produk');
        // Route::delete('/hapus-produk/{id}', [ProdukController::class,'destroy'])->name('hapus-produk');

    });
});