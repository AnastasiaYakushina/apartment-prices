<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentController;

Route::get('/', function () {
    return view('home');
});

Route::get('apartments', [ApartmentController::class, 'index'])->name('apartments.index');

Route::get('apartments/{apartment}', [ApartmentController::class, 'show'])->name('apartments.show');

Route::post('apartments', [ApartmentController::class, 'store'])->name('apartments.store');

Route::delete('apartments/{apartment}', [ApartmentController::class, 'destroy'])->name('apartments.destroy');

Route::post('apartments/{apartment}/refresh', [ApartmentController::class, 'refresh'])->name('apartments.refresh');
