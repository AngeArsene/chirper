<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::resource('chirps', ChirpController::class);
