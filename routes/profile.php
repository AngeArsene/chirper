<?php

use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UpdateProfileAvatarController;
use Illuminate\Support\Facades\Route;

// Profile view routes
Route::view('/', 'profile.show')->name('show');
Route::view('edit', 'profile.edit')->name('edit');
Route::view('password/edit', 'profile.password')->name('password.edit');

// Profile update routes
Route::match(['PUT', 'PATCH'], '/', 'update')
    ->name('update')
    ->middleware('password.confirm');

// Profile avatar update route
Route::match(['PUT', 'PATCH'], 'avatar/update', UpdateProfileAvatarController::class)
    ->name('avatar.update');

// Password update route
Route::match(['PUT', 'PATCH'], 'password/update', [PasswordController::class, 'update'])
    ->name('password.update');

// Profile signout route
Route::delete('/', 'destroy')
    ->name('destroy')
    ->middleware('password.confirm');
