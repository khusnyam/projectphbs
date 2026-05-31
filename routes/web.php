<?php

use App\Http\Controllers\DataPhbsController;
use App\Http\Controllers\PetaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhbsController;

Route::redirect('/', '/dashboard-phbs');
Route::get('/dashboard-phbs', [PhbsController::class, 'index'])->name('phbs.dashboard');
Route::get('/api/phbs/data', [PhbsController::class, 'getData'])->name('phbs.data');
Route::post('/api/phbs/simpan', [PhbsController::class, 'simpan'])->name('phbs.simpan');

use App\Http\Controllers\PhbsInputController;

Route::get(
    '/',
    [PhbsInputController::class, 'create']
);

Route::get(
    '/phbs/create',
    [PhbsInputController::class, 'create']
)->name('phbs.create');

Route::post(
    '/phbs/store',
    [PhbsInputController::class, 'store']
)->name('phbs.store');

Route::get(
    '/phbs/history',
    [PhbsInputController::class, 'history']
)->name('phbs.history');

Route::get(
    '/phbs/{id_phbs}/edit',
    [PhbsInputController::class, 'edit']
)->name('phbs.edit');


Route::put(
    '/phbs/{id_phbs}',
    [PhbsInputController::class, 'update']
)->name('phbs.update');

Route::delete(
    '/phbs/{id_phbs}',
    [PhbsInputController::class, 'destroy']
)->name('phbs.destroy');

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhbsController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/dinkes', [DashboardController::class, 'dinkes'])->name('dashboard.dinkes');

    // PHBS
    Route::get('/phbs',              [PhbsController::class, 'index'])->name('phbs.index');
    Route::get('/phbs/export',       [PhbsController::class, 'exportExcel'])->name('phbs.export');
    Route::get('/phbs/form',         [PhbsController::class, 'form'])->name('phbs.form');
    Route::post('/phbs',             [PhbsController::class, 'store'])->name('phbs.store');
    Route::get('/phbs/{id}/edit',    [PhbsController::class, 'edit'])->name('phbs.edit');
    Route::put('/phbs/{id}',         [PhbsController::class, 'update'])->name('phbs.update');
    Route::delete('/phbs/{id}',      [PhbsController::class, 'destroy'])->name('phbs.destroy');
});

// 1. Rute Halaman Utama (Mengalihkan langsung ke halaman peta)
Route::get('/', function () {
    return redirect('/peta');
});

// 2. Rute Utama Tampilan Peta
Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');

// 3. Kelompok Rute API Puskesmas & Peta (Dibutuhkan oleh AJAX / JavaScript)
Route::prefix('api')->group(function () {
    
    // Ambil data GeoJSON wilayah koordinat Puskesmas Sleman
    Route::get('/puskesmas/geojson', [PetaController::class, 'geojson'])->name('api.puskesmas.geojson');
    
    // Ambil data list tabel / datatable capaian PHBS Puskesmas
    Route::get('/puskesmas/list', [PetaController::class, 'list'])->name('api.puskesmas.list');
    
    // Ambil data periode bulan dan tahun filter laporan
    Route::get('/puskesmas/periode', [PetaController::class, 'periode'])->name('api.puskesmas.periode');
    
    // Ambil data detail info window ketika salah satu wilayah di peta diklik
    Route::get('/peta/detail/{id}', [PetaController::class, 'show'])->name('api.peta.detail');
    
});
