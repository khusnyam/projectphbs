<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhbsController;

Route::redirect('/', '/dashboard-phbs');
Route::get('/dashboard-phbs', [PhbsController::class, 'index'])->name('phbs.dashboard');
Route::get('/api/phbs/data', [PhbsController::class, 'getData'])->name('phbs.data');
Route::post('/api/phbs/simpan', [PhbsController::class, 'simpan'])->name('phbs.simpan');