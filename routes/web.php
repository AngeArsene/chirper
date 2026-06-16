<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index'])->name('chirps.index');

Route::middleware('auth.only')->group(function () {
    Route::resource('chirps', ChirpController::class)
        ->except('index', 'create', 'show');

    Route::view('profile', 'profile.show')->name('profile.show');
    Route::view('profile/edit', 'profile.edit')->name('profile.edit');

    Route::match(['PUT', 'PATCH'], 'profile', [UserProfileController::class, 'update'])->name('profile.update');

    Route::resource('profile', UserProfileController::class)
        ->only('destroy');
});
