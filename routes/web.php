<?php

use Illuminate\Support\Facades\Route;
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

    // PHBS
    Route::get('/phbs',              [PhbsController::class, 'index'])->name('phbs.index');
    Route::get('/phbs/export',       [PhbsController::class, 'exportExcel'])->name('phbs.export');
    Route::get('/phbs/form',         [PhbsController::class, 'form'])->name('phbs.form');
    Route::post('/phbs',             [PhbsController::class, 'store'])->name('phbs.store');
    Route::get('/phbs/{id}/edit',    [PhbsController::class, 'edit'])->name('phbs.edit');
    Route::put('/phbs/{id}',         [PhbsController::class, 'update'])->name('phbs.update');
    Route::delete('/phbs/{id}',      [PhbsController::class, 'destroy'])->name('phbs.destroy');
});