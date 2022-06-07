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

use App\Http\Controllers\UsersController;
Route::resource('User', UsersController::class);
