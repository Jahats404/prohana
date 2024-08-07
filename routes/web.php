`<?php

use App\Http\Controllers\agen\pesanan\PesananController as PesananAgenController;
use App\Http\Controllers\agen\produk\ProdukController as ProdukAgenController;
use App\Http\Controllers\agen\distributor\DistributorController as DistributorAgenController;
use App\Http\Controllers\agen\garansi\AgenGaransiController;
use App\Http\Controllers\agen\keranjang\KeranjangController;
use App\Http\Controllers\agen\pengiriman\AgenPengirimanController;
use App\Http\Controllers\agen\pengiriman\AgenPengirimanGaransiController;
use App\Http\Controllers\agen\pengiriman\AgenPengirimanPesananController;
use App\Http\Controllers\agen\produk\BarangController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\distributor\agen\AgenController as AgenAgenController;
use App\Http\Controllers\distributor\garansi\DistributorGaransiController;
use App\Http\Controllers\distributor\pengiriman\PengirimanController as PengirimanPengirimanController;
use App\Http\Controllers\distributor\pesanan\PesananController;
use App\Http\Controllers\produsen\pengiriman\PengirimanController;
use App\Http\Controllers\Produsen\akun\AgenController;
use App\Http\Controllers\produsen\akun\DistributorController;
use App\Http\Controllers\produsen\akun\ProdusenAgenController;
use App\Http\Controllers\produsen\garansi\ProdusenGaransiController;
use App\Http\Controllers\produsen\pesanan\PesananController as PesananProdusenController;
use App\Http\Controllers\produsen\produk\ProdukController;
use App\Http\Controllers\ProfileController;
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

route::get('/', [AuthController::class,'login'])->name('login');
route::post('/authenticate', [AuthController::class,'authenticate'])->name('authenticate');
route::post('/logout', [AuthController::class,'logout'])->name('logout');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/stok/{produk_id}/{warna}/{ukuran}', [PesananAgenController::class, 'getStock'])->name('getStock');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::get('/security', [ProfileController::class,'editPass'])->name('security');
    Route::put('/security', [ProfileController::class,'updatePassword'])->name('security.update');


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
        Route::get('/detail-produk/{id}', [ProdukController::class, 'show'])->name('show-produk');
        Route::post('/produk', [ProdukController::class,'store'])->name('store-produk');
        Route::put('/produk/{id}', [ProdukController::class,'update'])->name('edit-produk');
        Route::delete('/produk/{id}', [ProdukController::class,'destroy'])->name('delete-produk');
        Route::post('/tambah-stok/{id}', [ProdukController::class,'tambah_stok'])->name('tambah-stok-produk');

        // Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('hapus-produk');


        // KELOLA AGEN
        Route::get('/agen', [ProdusenAgenController::class,'index'])->name('kelola-agen');
        Route::post('/agen', [ProdusenAgenController::class, 'store'])->name('store-agen');
        Route::put('/agen/{id}', [ProdusenAgenController::class, 'update'])->name('update-agen');
        Route::delete('/agen/{id}', [ProdusenAgenController::class, 'destroy'])->name('delete-agen');

        // KELOLA PESANAN
        Route::get('pesanan', [PesananProdusenController::class, 'index'])->name('kelola-pesanan');
        Route::get('pesanan/{id}', [PesananProdusenController::class, 'show'])->name('show-pesanan');
        Route::put('pesanan/status/{id}', [PesananProdusenController::class, 'updateStatus'])->name('update-status-pesanan');
        // Route::delete('pesanan/destroy/{id}', [PesananProdusenController::class, 'destroy'])->name('pesanan.destroy');
        // Route::put('pesanan/status/{id}', [PesananProdusenController::class, 'status'])->name('pesanan.status');

        // KELOLA DISTRIBUSI
        Route::get('pengiriman', [PengirimanController::class, 'index'])->name('kelola-pengiriman');
        Route::get('/detail-pengiriman/{id}', [PengirimanController::class, 'show'])->name('show-pengiriman');

        // KELOLA GARANSI
        Route::get('garansi', [ProdusenGaransiController::class, 'index'])->name('kelola-garansi');
        Route::get('detail-garansi/{id}', [ProdusenGaransiController::class, 'show'])->name('show-garansi');
        Route::put('verifikasi-garansi/{id}', [ProdusenGaransiController::class, 'verifikasi'])->name('verifikasi-garansi');

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

        Route::get('/agen', [AgenAgenController::class, 'index'])->name('agen');

        //Pengiriman
        Route::get('/pengiriman', [PengirimanPengirimanController::class, 'index'])->name('pengiriman');
        Route::get('/detail-pengiriman/{id}', [PengirimanPengirimanController::class, 'show'])->name('detail-pengiriman');
        Route::post('/store-pengiriman', [PengirimanPengirimanController::class, 'store'])->name('store-pengiriman');
        Route::put('/status-pengiriman/{id}', [PengirimanPengirimanController::class, 'status'])->name('status-pengiriman');
        Route::put('/pengembalian/{id}', [PengirimanPengirimanController::class, 'pengembalian'])->name('pengembalian');

        // KELOLA PESANAN
        Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
        Route::get('/detail-pesanan/{id}', [PesananController::class, 'show'])->name('show-pesanan');

        // KELOLA GARANSI
        Route::get('/garansi', [DistributorGaransiController::class, 'index'])->name('garansi');

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

        //PESANAN
        Route::get('/daftar-pesanan', [PesananAgenController::class, 'index'])->name('daftar-pesanan');
        Route::get('/pesanan', [PesananAgenController::class, 'pesanan'])->name('pesanan');
        Route::get('/pesanan/{id}', [PesananAgenController::class, 'show'])->name('detail-pesanan');
        Route::post('/pesanan', [PesananAgenController::class, 'store'])->name('store-pesanan');
        Route::get('/detail-produk/{id}', [ProdukAgenController::class, 'show'])->name('detail-produk');


        // keranjang
        Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
        Route::post('/keranjang', [KeranjangController::class, 'keranjang'])->name('store-keranjang');

        // Route::get('/dashboard', [AgenController::class, 'dashboard'])->name('dashboard');
        Route::get('/produk', [ProdukAgenController::class, 'index'])->name('produk');
        // Route::get('/produk/{id}', [ProdukAgenController::class, 'show'])->name('detail-produk');

        Route::get('/distributor', [DistributorAgenController::class, 'index'])->name('distributor');
        Route::get('/distributor/{id}', [DistributorAgenController::class, 'show'])->name('detail-distributor');

        // KELOLA PENGIRIMAN
        Route::get('/pengiriman', [AgenPengirimanPesananController::class, 'index'])->name('pengiriman');
        Route::get('/detail-pengiriman/{id}', [AgenPengirimanPesananController::class, 'show'])->name('show-pengiriman');

        Route::get('/pengiriman-garansi', [AgenPengirimanGaransiController::class, 'index'])->name('pengiriman-garansi');
        Route::get('/detail-pengiriman/garansi/{id}', [AgenPengirimanGaransiController::class, 'show'])->name('show-pengiriman-garansi');

        //BARANG
        Route::get('/barang-tersedia', [BarangController::class, 'index'])->name('barang-tersedia');
        Route::get('/seluruh-barang', [BarangController::class, 'all_produk'])->name('all-produk');
        Route::get('/barang-terjual/{id}', [BarangController::class, 'terjual'])->name('barang-terjual');
        Route::post('/garansi/{id}', [AgenGaransiController::class, 'klaim_garansi'])->name('garansi');


        // Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
        // Route::post('/tambah-produk', [ProdukController::class,'store'])->name('tambah-produk');
        // Route::put('/edit-produk/{id}', [ProdukController::class,'update'])->name('edit-produk');
        // Route::delete('/hapus-produk/{id}', [ProdukController::class,'destroy'])->name('hapus-produk');

    });
});