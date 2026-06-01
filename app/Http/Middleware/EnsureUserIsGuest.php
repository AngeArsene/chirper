<?php

namespace App\Http\Middleware;

use App\AuthRouteNameToAction;
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
        $action = AuthRouteNameToAction::from(Route::currentRouteName())->label();

        if (Auth::check()) {
            return redirect()
                ->route('chirps.index')
                ->with(
                    'success',
                    "You are already authenticated. No need to $action again."
                );
        }

        return $next($request);
    }
}
