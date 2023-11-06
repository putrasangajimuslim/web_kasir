<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KelolaGajiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
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

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('dashboard', [KehadiranController::class, 'index'])->name('dashboard');

Route::post('cek-kehadiran', [KehadiranController::class, 'cekKehadiran'])->name('cek-kehadiran');
Route::post('rekam-kehadiran', [KehadiranController::class, 'rekamKehadiran'])->name('rekam-kehadiran');

Route::middleware(['isLogin'])->group(function () {

    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('kehadiran')->as('kehadiran.')->group(function () {
        Route::get('/', [KehadiranController::class, 'index'])->name('index');
        Route::get('create', [KehadiranController::class, 'create'])->name('create');
        Route::post('store', [KehadiranController::class, 'store'])->name('store');
        Route::get('edit/{id}', [KehadiranController::class, 'edit'])->name('edit');
        Route::post('update', [KehadiranController::class, 'update'])->name('update');
        Route::get('destroy{id}', [KehadiranController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users')->as('users.')->middleware(['admin'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('update', [UserController::class, 'update'])->name('update');
        Route::get('aktivasi-akun/{id}', [UserController::class, 'activation_account'])->name('aktivasi-akun');
        Route::get('destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('kelolagaji')->as('kelolagaji.')->middleware(['admin'])->group(function () {
        Route::get('/', [KelolaGajiController::class, 'index'])->name('index');
        Route::get('edit/{id}', [KelolaGajiController::class, 'edit'])->name('edit');
        Route::post('update', [KelolaGajiController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [KelolaGajiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('laporan')->as('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('detail-slipgaji', [LaporanController::class, 'detailSlipGaji'])->name('detail-slipgaji');
        Route::get('detail-rekapgaji', [LaporanController::class, 'detailRekapGaji'])->name('detail-rekapgaji');
        Route::get('print/{id}', [LaporanController::class, 'print'])->name('print');
        Route::get('detail-periode-rekapgaji/{bln}/{thn}', [LaporanController::class, 'detailPeriodeRekapGajiPeriode'])->name('detail-periode-rekapgaji');
        Route::get('print-detail-periode-rekapgaji/{bln}/{thn}', [LaporanController::class, 'printPeriodeRekapGajiPeriode'])->name('print-detail-periode-rekapgaji');
    });

});
