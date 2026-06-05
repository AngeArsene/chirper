<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Handles authentication flow for the application.
 */
class AuthController extends Controller
{
    /**
     * Create a new user account and log the user in.
     *
     * @param RegisterUserRequest $request Validated registration data.
     * @return RedirectResponse Redirect to the chirps index on success.
     */
    public function register(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        Auth::login($user);

        return redirect()
            ->route('chirps.index')
            ->with('success', __('Account created successfully!'));
    }

    /**
     * Authenticate a user using validated credentials.
     *
     * @param LoginUserRequest $request Validated login credentials.
     * @return RedirectResponse Redirect to the intended destination or back with errors.
     */
    public function login(LoginUserRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        // Attempt to log in
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session for security
            $request->session()->regenerate();

            // Redirect to intended page or home
            return redirect()->intended('/')->with('success', __('Welcome back! ') . Auth::user()->name);
        }

        // If login fails, redirect back with error
        return back()
            ->withErrors(['email' => __('The provided credentials do not match our records.')])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('chirps.index')->with('success', __('Logged out successfully!'));
    }
}
