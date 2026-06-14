<?php

use App\Http\Controllers\PetaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhbsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PhbsInputController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardPhbsController;
use App\Http\Controllers\PBerandaController;

Route::get('/', function () {
    return redirect()->route('login');
});

//guest
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

   

//auth
// Route::middleware(['auth','can:akses-dinkes'])->group(function () {
Route::middleware(['auth', 'role:dinkes'])->group(function () {
    // Route::middleware('auth')->group(function(){
        Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::get('/dashboard-phbs', [DashboardPhbsController::class, 'index'])->name('dashboard.phbs');
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



        // //laporan phbs
        // Route::prefix('laporan-phbs')->name('laporan.')->group(function () {
        //     Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/laporan-phbs',              [LaporanController::class, 'index'])->name('phbs.index');
        Route::get('/laporan-phbs/export',       [LaporanController::class, 'exportExcel'])->name('phbs.export');
        Route::get('/laporan-phbs/form',         [LaporanController::class, 'form'])->name('laporan-phbs.form');
        Route::post('/laporan-phbs',             [LaporanController::class, 'store'])->name('laporan-phbs.store');
        Route::get('/laporan-phbs/{id}/edit',    [LaporanController::class, 'edit'])->name('laporan.edit');
        Route::put('/laporan-phbs/{id}',         [LaporanController::class, 'update'])->name('laporan-phbs.update');
        Route::delete('/laporan-phbs/{id}',      [LaporanController::class, 'destroy'])->name('laporan.destroy');

    // });
// });

//AKSES PUSKESMAS
Route::middleware(['auth', 'role:puskesmas'])->group(function () {
// Route::middleware(['auth', 'can:akses-puskesmas'])->group(function(){
    // Route::redirect('/', '/dashboard');
    Route::get('/dashboard', [PBerandaController::class, 'index'])->name('dashboard');
    //     // Route::get('/dashboard-puskesmas', [PhbsController::class, 'index'])->name('puskesmas.dashboard');
    //     // Route::get('/api/phbs/data', [PhbsController::class, 'getData'])->name('phbs.data');
    //     // Route::post('/api/phbs/simpan', [PhbsController::class, 'simpan'])->name('phbs.simpan');
     // supaya Laravel tidak menganggap "create" sebagai {id_phbs}
    // Route::get('/phbs/create',         [PhbsInputController::class, 'index']  )->name('phbs.create');
    // Route::prefix('phbs')->name('formulir.')->group(function() {
    Route::get('/phbs',                [PhbsInputController::class, 'index']  )->name('formulir.input');
    Route::post('/phbs/store',         [PhbsInputController::class, 'store']  )->name('formulir.store');
    Route::get('/phbs/{id_phbs}/edit', [PhbsInputController::class, 'edit']   )->name('formulir.edit');
    Route::put('/phbs/{id_phbs}',      [PhbsInputController::class, 'update'] )->name('formulir.update');
    Route::delete('/phbs/{id_phbs}',   [PhbsInputController::class, 'destroy'])->name('formulir.destroy');
});
});