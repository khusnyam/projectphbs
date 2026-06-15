<?php

use App\Http\Controllers\PetaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PhbsInputController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardPhbsController;
use App\Http\Controllers\PBerandaController;

Route::get('/', fn() => redirect()->route('login'));

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:dinkes'])->group(function () {

    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/dashboard-phbs', [DashboardPhbsController::class, 'index'])->name('dashboard.phbs');
    Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');

    Route::prefix('api')->group(function () {
        Route::get('/puskesmas/geojson', [PetaController::class, 'geojson'])->name('api.puskesmas.geojson');
        Route::get('/puskesmas/list',    [PetaController::class, 'list'])->name('api.puskesmas.list');
        Route::get('/puskesmas/periode', [PetaController::class, 'periode'])->name('api.puskesmas.periode');
        Route::get('/peta/detail/{id}',  [PetaController::class, 'show'])->name('api.peta.detail');
    });

    Route::get('/laporan-phbs',           [LaporanController::class, 'index'])->name('phbs.index');
    Route::get('/laporan-phbs/export',    [LaporanController::class, 'exportExcel'])->name('formulir.export_history');
}); 

Route::middleware(['auth', 'role:puskesmas'])->group(function () {

    Route::get('/dashboard',           [PBerandaController::class, 'index'])->name('dashboard');
    Route::get('/phbs',                [PhbsInputController::class, 'index'])->name('formulir.input');
    Route::post('/phbs/store',         [PhbsInputController::class, 'store'])->name('formulir.store');
    Route::get('/phbs/{id_phbs}/edit', [PhbsInputController::class, 'edit'])->name('formulir.edit');
    Route::put('/phbs/{id_phbs}',      [PhbsInputController::class, 'update'])->name('formulir.update');
    Route::delete('/phbs/{id_phbs}',   [PhbsInputController::class, 'destroy'])->name('formulir.destroy');

}); 