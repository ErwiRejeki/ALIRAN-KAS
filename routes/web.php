<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\BarangController;
Route::resource('barang', BarangController::class);

use App\Http\Controllers\SupplierController;
Route::resource('supplier', SupplierController::class);

use App\Http\Controllers\BiayaController;
Route::resource('biaya', BiayaController::class);

use App\Http\Controllers\TransaksiBiayaController;
Route::resource('transaksi_biaya', TransaksiBiayaController::class);

use App\Http\Controllers\UserController;
Route::resource('user', UserController::class);

use App\Http\Controllers\TransaksiPembelianController;
Route::get('/transaksi_pembelian', [TransaksiPembelianController::class, 'index'])->name('pembelian');
Route::get('/transaksi_pembelian/transaksi/{id?}', [TransaksiPembelianController::class, 'transaksi'])->name('pembelian.transaksi');
Route::get('/transaksi_pembelian/faktur/{id}/{type}/{retur?}', [TransaksiPembelianController::class, 'faktur'])->name('pembelian.faktur');
Route::post('/transaksi_pembelian/barang_store', [TransaksiPembelianController::class, 'barang_store'])->name('pembelian.barang_store');
Route::post('/transaksi_pembelian/store', [TransaksiPembelianController::class, 'store'])->name('pembelian.store');
Route::post('/transaksi_pembelian/faktur_store', [TransaksiPembelianController::class, 'faktur_store'])->name('pembelian.faktur_store');
Route::delete('/transaksi_pembelian/barang_delete', [TransaksiPembelianController::class, 'barang_delete'])->name('pembelian.barang_delete');
// Route::get('transaksi_pembelian', TransaksiPembelianController::class);

use App\Http\Controllers\TransaksiPenjualanController;
Route::get('/transaksi_penjualan', [TransaksiPenjualanController::class, 'index'])->name('penjualan');
Route::get('/transaksi_penjualan/transaksi/{id?}', [TransaksiPenjualanController::class, 'transaksi'])->name('penjualan.transaksi');
Route::get('/transaksi_penjualan/faktur/{id}/{type}/{retur?}', [TransaksiPenjualanController::class, 'faktur'])->name('penjualan.faktur');
Route::post('/transaksi_penjualan/barang_store', [TransaksiPenjualanController::class, 'barang_store'])->name('penjualan.barang_store');
Route::post('/transaksi_penjualan/store', [TransaksiPenjualanController::class, 'store'])->name('penjualan.store');
Route::post('/transaksi_penjualan/faktur_store', [TransaksiPenjualanController::class, 'faktur_store'])->name('penjualan.faktur_store');
Route::delete('/transaksi_penjualan/barang_delete', [TransaksiPenjualanController::class, 'barang_delete'])->name('penjualan.barang_delete');
// Route::get('transaksi_pembelian', TransaksiPembelianController::class);

use App\Http\Controllers\JurnalController;
Route::get('/jurnal/jpenerimaankas', [JurnalController::class, 'jpenerimaankas'])->name('jurnal.jpenerimaankas');
Route::get('/jurnal/jpembelian', [JurnalController::class, 'jpembelian'])->name('jurnal.jpembelian');
Route::get('/jurnal/jpenjualan', [JurnalController::class, 'jpenjualan'])->name('jurnal.jpenjualan');
Route::get('/jurnal/jpengeluarankas', [JurnalController::class, 'jpengeluarankas'])->name('jurnal.jpengeluarankas');

use App\Http\Controllers\LaporanController;
Route::get('/laporan/lpembelian', [LaporanController::class, 'lpembelian'])->name('laporan.lpembelian');
Route::get('/laporan/lpenjualan', [LaporanController::class, 'lpenjualan'])->name('laporan.lpembelian');
Route::get('/laporan/lpenerimaankas',[LaporanController::class, 'lpenerimaankas'])->name('laporan.lpenerimaankas');
Route::get('/laporan/lpengeluarankas',[LaporanController::class, 'lpengeluarankas'])->name('laporan.lpengeluarankas');
Route::get('/laporan/lbukubesarkas', [LaporanController::class, 'lbukubesarkas'])->name('laporan.lbukubesarkas');
Route::get('/laporan/laruskas', [LaporanController::class, 'laruskas'])->name('laporan.laruskas');
