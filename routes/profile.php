<?php

use App\Http\Controllers\UserPasswordUpdate;
use Illuminate\Support\Facades\Route;

Route::view('/', 'profile.show')->name('show');
Route::view('edit', 'profile.edit')->name('edit');
Route::view('password/edit', 'profile.password')->name('password.edit');

Route::match(['PUT', 'PATCH'], '/', 'update')
    ->name('update')
    ->middleware('password.confirm');

Route::match(['PUT', 'PATCH'], 'password/update', UserPasswordUpdate::class)
    ->name('password.update');

Route::delete('/', 'destroy')->name('destroy');
