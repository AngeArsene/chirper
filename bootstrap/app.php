<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureUserIsAuthenticated;
use App\Http\Middleware\EnsureUserIsGuest;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: fn () => Route::middleware(['web', 'guest.only'])
            ->prefix('auth')->name('auth.')
            ->controller(AuthController::class)->group(__DIR__.'/../routes/auth.php'),
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guest.only' => EnsureUserIsGuest::class,
            'auth.only' => EnsureUserIsAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
