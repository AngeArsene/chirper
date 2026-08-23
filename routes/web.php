<?php

use App\Http\Controllers\ChirpBookmarkController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ChirpLikeController;
use Illuminate\Support\Facades\Route;

// Home page route
Route::get('/', [ChirpController::class, 'index'])->name('chirps.index');

// Chirp resource routes
Route::resource('chirps', ChirpController::class)
    ->except('index', 'create', 'show')
    ->middleware('auth.only')
    ->middlewareFor('store', 'throttle:4,1')
    ->middlewareFor('update', 'throttle:5,1')
    ->middlewareFor('destroy', 'throttle:3,1');

// Chirp like/unlike routes
Route::match(['post', 'delete'], '/chirps/{chirp}/like', ChirpLikeController::class)
    ->middleware(['auth.only', 'throttle:16,1'])
    ->name('chirps.like');

// Chirp bookmarks routes
Route::middleware('auth.only')
    ->prefix('chirps')->name('chirps.')
    ->controller(ChirpBookmarkController::class)
    ->group(function (): void {
        Route::get('/bookmarks', 'index')->name('bookmarks');

        Route::match(['post', 'delete'], '/{chirp}/bookmarks', 'toggle')
            ->name('bookmark')
            ->middleware('throttle:16,1');
    });
