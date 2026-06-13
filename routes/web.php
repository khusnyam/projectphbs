<?php

use App\Http\Controllers\PetaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhbsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PhbsInputController;
use App\Http\Controllers\BerandaController;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Protected
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard',           [DashboardController::class, 'dinkes'])->name('dashboard.dinkes');
    Route::get('/dashboard/puskesmas', [DashboardController::class, 'puskesmas'])->name('dashboard.puskesmas');
    Route::get('/dashboard/redirect',  [DashboardController::class, 'redirect'])->name('dashboard');

    // Beranda & Dashboard PHBS
    Route::get('/beranda',       [BerandaController::class, 'index'])->name('beranda');
    Route::get('/dashboard-phbs',[DashboardController::class, 'dinkes'])->name('phbs.dashboard');

    // Peta
    Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');

    // API Peta & Puskesmas
    Route::prefix('api')->group(function () {
        Route::get('/puskesmas/geojson',  [PetaController::class, 'geojson'])->name('api.puskesmas.geojson');
        Route::get('/puskesmas/list',     [PetaController::class, 'list'])->name('api.puskesmas.list');
        Route::get('/puskesmas/periode',  [PetaController::class, 'periode'])->name('api.puskesmas.periode');
        Route::get('/peta/detail/{id}',   [PetaController::class, 'show'])->name('api.peta.detail');
    });

    // Laporan PHBS — Dinkes (LaporanController)
    Route::get('/laporan-phbs',           [LaporanController::class, 'index'])->name('phbs.index');
    Route::get('/laporan-phbs/export',    [LaporanController::class, 'exportExcel'])->name('phbs.export');
    Route::get('/laporan-phbs/form',      [LaporanController::class, 'form'])->name('phbs.form');
    Route::get('/laporan-phbs/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan-phbs/{id}',      [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan-phbs/{id}',   [LaporanController::class, 'destroy'])->name('laporan.destroy');

    // Dashboard Puskesmas
    Route::get('/dashboard-puskesmas', [PhbsController::class, 'index'])->name('puskesmas.dashboard');
    Route::post('/api/phbs/simpan',    [PhbsController::class, 'simpan'])->name('phbs.simpan');

    // Input PHBS — Puskesmas (PhbsInputController)
    Route::get('/phbs',              [PhbsInputController::class, 'create']);
    Route::get('/phbs/create',       [PhbsInputController::class, 'create'])->name('phbs.create');
    Route::post('/phbs/store',       [PhbsInputController::class, 'store'])->name('phbs.store');
    Route::get('/phbs/history',      [PhbsInputController::class, 'history'])->name('phbs.history');
    Route::get('/phbs/{id_phbs}/edit',  [PhbsInputController::class, 'edit'])->name('phbs.edit');
    Route::put('/phbs/{id_phbs}',       [PhbsInputController::class, 'update'])->name('phbs.update');
    Route::delete('/phbs/{id_phbs}',    [PhbsInputController::class, 'destroy'])->name('phbs.destroy');
});