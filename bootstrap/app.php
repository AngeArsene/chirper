<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\EnsureUserIsAuthenticated;
use App\Http\Middleware\EnsureUserIsGuest;
use App\Http\Middleware\EnsureUserIsUnconfirmed;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {
            // Auth Routes
            Route::middleware(['web', 'guest.only'])
                ->prefix('auth')->name('auth.')
                ->controller(AuthController::class)
                ->group(base_path('routes'.DIRECTORY_SEPARATOR.'auth.php'));

            // Profile Routes
            Route::middleware(['web', 'auth.only'])
                ->prefix('profile')->name('profile.')
                ->controller(UserProfileController::class)
                ->group(base_path('routes'.DIRECTORY_SEPARATOR.'profile.php'));

            // Password Routes
            Route::middleware(['web', 'auth.only', 'unconfirmed.only'])
                ->prefix('password')->name('password.')
                ->group(function (): void {
                    Route::view('confirm', 'auth.passwords.confirm')
                        ->name('confirm');

                    Route::post('verify', [PasswordController::class, 'verify'])
                        ->name('verify');
                });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guest.only' => EnsureUserIsGuest::class,
            'auth.only' => EnsureUserIsAuthenticated::class,
            'unconfirmed.only' => EnsureUserIsUnconfirmed::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
