<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsUnconfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $confirmed_at = $request->session()->get('auth.password_confirmed_at') ?? false;

        $is_confirmed = $confirmed_at && (time() - $confirmed_at) < config('auth.password_timeout', 10800);

        $is_from_confirmation = url()->previous() === route('profile.edit') || url()->previous() === route('password.confirm');

        if ($is_confirmed || ! $is_from_confirmation) {
            return back()->with(
                'error',
                'You have either already confirmed your password or you do not need to confirm it yet.'
            );
        }

        return $next($request);
    }
}
