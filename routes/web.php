<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentController;

Route::get('/', function () {
    return view('home');
});

Route::get('apartments', [ApartmentController::class, 'index'])->name('apartments.index');

Route::get('apartments/{id}', [ApartmentController::class, 'show'])->name('apartments.show');

Route::post('apartments', [ApartmentController::class, 'store'])->name('apartments.store');