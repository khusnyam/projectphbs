<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhbsController;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Protected
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',          [DashboardController::class, 'dinkes'])->name('dashboard.dinkes');
    Route::get('/dashboard/puskesmas',[DashboardController::class, 'puskesmas'])->name('dashboard.puskesmas');

    // Alias /dashboard → auto redirect sesuai role
    Route::get('/dashboard/redirect', [DashboardController::class, 'redirect'])->name('dashboard');

    // PHBS
    Route::get('/phbs', [PhbsController::class, 'index'])->name('phbs.index');
    Route::get('/phbs/form', [PhbsController::class, 'form'])->name('phbs.form');
    Route::get('/phbs/export', [PhbsController::class, 'exportExcel'])->name('phbs.export');
});