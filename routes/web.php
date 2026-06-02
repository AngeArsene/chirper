<?php

use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index'])->name('chirps.index');
Route::resource('chirps', ChirpController::class)
    ->except('index', 'create')
    ->middleware('auth.only');
