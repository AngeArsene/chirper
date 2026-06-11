<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index'])->name('chirps.index');

Route::middleware('auth.only')->group(function () {
    Route::resource('chirps', ChirpController::class)
        ->except('index', 'create', 'show');

    Route::view('profile', 'profile.show')->name('profile.show');

    Route::resource('profile', UserProfileController::class)
        ->only('update', 'destroy');
});
