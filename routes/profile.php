<?php

use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::resource('profile', UserProfileController::class)
    ->only(['show', 'update', 'destroy']);
