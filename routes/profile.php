<?php

use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\UpdateProfileAvatarController;
use App\Http\Controllers\UpdateProfileCoverController;
use Illuminate\Support\Facades\Route;

// Profile view routes
Route::view('/', 'profile.show')->name('show');
Route::view('edit', 'profile.edit')->name('edit');
Route::view('password/edit', 'profile.password.edit')
    ->name('password.edit');

// Profile update routes
Route::match(['PUT', 'PATCH'], '/update', 'update')
    ->name('update')
    ->middleware('password.confirm');

// Profile signout route
Route::delete('/signout', 'destroy')
    ->name('destroy')
    ->middleware('password.confirm');

// Profile avatar update route
Route::match(['PUT', 'PATCH'], 'avatar', UpdateProfileAvatarController::class)
    ->name('avatar.update');

// Profile cover update route
Route::match(['PUT', 'PATCH'], 'cover', UpdateProfileCoverController::class)
    ->name('cover.update');

// Profile password update route
Route::match(['PUT', 'PATCH'], 'password', UpdatePasswordController::class)
    ->name('password.update');
