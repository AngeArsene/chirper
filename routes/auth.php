<?php

use Illuminate\Support\Facades\Route;

Route::get('/sign-up', 'sign_up')->name('sign-up');
Route::post('/register', 'register')->name('register');
