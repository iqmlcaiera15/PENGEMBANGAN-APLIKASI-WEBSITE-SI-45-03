<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukSuppplierController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupplierController;
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

Route::redirect('/', '/login', 301);

Auth::routes();

// admin
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // roles
    Route::resource('roles', RoleController::class)->except('show');
    // permissions
    Route::resource('permissions', PermissionController::class)->except('show');

    // kategori
    Route::resource('kategori', KategoriController::class)->except('show');
    // produk
    Route::resource('produk', ProdukController::class)->except('show');
    Route::get('/produk/getByJson', [ProdukController::class, 'getByIdJson'])->name('produk.getByIdJson');
    // penjualan
    Route::resource('penjualan', PenjualanController::class)->except('show');
    // supplier
    Route::resource('supplier', SupplierController::class)->except('show');

    // produk-supplier
    Route::resource('produk-supplier', ProdukSuppplierController::class)->except('show');
    Route::get('/produk-supplier/getByJson', [ProdukSuppplierController::class, 'getByIdJson'])->name('produk-supplier.getByIdJson');

    // project
    Route::resource('project', ProjectController::class)->except('show');

    // pemasukan
    Route::resource('pemasukan', PemasukanController::class)->except('show');

    // pengeluaran
    Route::resource('pengeluaran', PengeluaranController::class)->except('show');
});
