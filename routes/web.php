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
Route::resource('transaksi_pembelian', TransaksiPembelianController::class);
