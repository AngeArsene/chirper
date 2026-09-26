<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyPasswordRequest;
use Illuminate\Http\RedirectResponse;

class VerifyPasswordController extends Controller
{
    /**
     * Confirm the authenticated user's password.
     */
    public function __invoke(VerifyPasswordRequest $request): RedirectResponse
    {
        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('profile.edit'));
    }
}
