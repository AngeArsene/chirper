<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

/**
 * Handles a profile password-change request submitted through the password edit route.
 */
class PasswordController extends Controller
{
    /**
     * Updates the authenticated user's password and returns to the profile password view.
     *
     * @param  UserPasswordUpdateRequest  $request  A validated profile password-change request.
     * @return RedirectResponse Redirects to the profile password page with a success message.
     *
     * @throws ValidationException If the incoming request payload fails the `UserPasswordUpdateRequest` rules.
     */
    public function update(UserPasswordUpdateRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => $request->validated('password'),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'password' => ['required', 'string', Password::defaults(), 'current_password'],
            ],
            [
                'password.required' => 'Please enter your password.',
                'password.string' => 'The password must be a valid string.',
                'password.current_password' => 'The password you entered is incorrect.',
            ]
        );

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('profile.edit'));
    }
}
