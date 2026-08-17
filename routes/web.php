<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ChirpLikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index'])->name('chirps.index');

Route::resource('chirps', ChirpController::class)
    ->except('index', 'create', 'show')
    ->middleware('auth.only')
    ->middlewareFor('store', 'throttle:4,1')
    ->middlewareFor('update', 'throttle:5,1')
    ->middlewareFor('destroy', 'throttle:3,1');


Route::match(['post', 'delete'], '/chirps/{chirp}/like', ChirpLikeController::class)
    ->middleware(['auth.only', 'throttle:4,1'])
    ->name('chirps.like');
