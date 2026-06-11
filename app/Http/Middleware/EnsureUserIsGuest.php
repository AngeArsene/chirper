<?php

namespace App\Http\Middleware;

use App\Enums\AppRouteNameToAction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $action = AppRouteNameToAction::tryFrom(Route::currentRouteName())?->label() ?? 'authenticate';

        if (Auth::check()) {
            return back()->with(
                'error',
                __("You are already authenticated. No need to $action again.")
            );
        }

        return $next($request);
    }
}
