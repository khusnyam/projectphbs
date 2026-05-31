<?php

use Illuminate\Support\Facades\Route;
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
