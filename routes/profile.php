<?php

use Illuminate\Support\Facades\Route;

Route::view('profile', 'profile.show')->name('show');
Route::view('profile/edit', 'profile.edit')->name('edit');

Route::match(['PUT', 'PATCH'], 'profile', 'update')->name('update');

Route::delete('profile', 'destroy')->name('destroy');
