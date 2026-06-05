<?php

use Illuminate\Support\Facades\Route;

// Authentication page routes
Route::view('/login', 'auth.sign-in')->name('sign-in');
Route::view('/register', 'auth.sign-up')->name('sign-up');

// Authentication form submission routes
Route::post('/login', 'login')->name('login');
Route::post('/register', 'register')->name('register');

// Logout route
Route::post('/logout', 'logout')
    ->name('logout')
    ->withoutMiddleware('guest.only')
    ->middleware('auth.only');
