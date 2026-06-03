<?php

use Illuminate\Support\Facades\Route;

Route::get('/sign-up', 'sign_up')->name('sign-up');
Route::post('/register', 'register')->name('register');

Route::get('/sign-in', 'sign_in')->name('sign-in');
Route::post('/login', 'login')->name('login');
