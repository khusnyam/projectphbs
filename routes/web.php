<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhbsController;
use App\Http\Controllers\PetaController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/peta');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| AUTH PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |-------------------------
    | PHBS FEATURE (FIXED)
    |-------------------------
    */
    Route::get('/phbs', [PhbsController::class, 'index'])->name('phbs.index');
    Route::get('/phbs/form', [PhbsController::class, 'form'])->name('phbs.form');
    Route::post('/phbs', [PhbsController::class, 'store'])->name('phbs.store');
    Route::get('/phbs/{id}/edit', [PhbsController::class, 'edit'])->name('phbs.edit');
    Route::put('/phbs/{id}', [PhbsController::class, 'update'])->name('phbs.update');
    Route::delete('/phbs/{id}', [PhbsController::class, 'destroy'])->name('phbs.destroy');

    Route::get('/phbs/export', [PhbsController::class, 'exportExcel'])->name('phbs.export');

});

/*
|--------------------------------------------------------------------------
| PETA
|--------------------------------------------------------------------------
*/
Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');

/*
|--------------------------------------------------------------------------
| API PETA
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {

    Route::get('/puskesmas/geojson', [PetaController::class, 'geojson'])->name('api.puskesmas.geojson');

    Route::get('/puskesmas/list', [PetaController::class, 'list'])->name('api.puskesmas.list');

    Route::get('/puskesmas/periode', [PetaController::class, 'periode'])->name('api.puskesmas.periode');

    Route::get('/peta/detail/{id}', [PetaController::class, 'show'])->name('api.peta.detail');

});