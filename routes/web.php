<?php

use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index'])->name('chirps.index');

Route::resource('chirps', ChirpController::class)
    ->except('index', 'create', 'show')
    ->middleware('auth.only')
    ->middlewareFor('store', 'throttle:8,1')
    ->middlewareFor('update', 'throttle:10,1')
    ->middlewareFor('destroy', 'throttle:20,1');
