<?php

namespace App\Http\Middleware;

use App\Enums\AppRouteNameToAction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $action = AppRouteNameToAction::tryFrom(Route::currentRouteName())?->label() ??
            'perform this action on';

        if (Auth::guest()) {
            return to_route('auth.sign-in')
                ->with(
                    'error',
                    __("You must be authenticated to $action. Please consider signing in or signing up.")
                );
        }

        return $next($request);
    }
}
