<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordVerifyRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
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
    public function update(UserPasswordUpdateRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        $user->update(['password' => $request->validated('password')]);

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
    }

    /**
     * Verifies the authenticated user's password and returns to the profile edit view.
     *
     * @param  PasswordVerifyRequest  $request  A validated password verification request.
     * @return RedirectResponse Redirects to the profile edit page if the password is verified.
     *
     * @throws ValidationException If the incoming request payload fails the `PasswordVerifyRequest` rules.
     */
    public function verify(PasswordVerifyRequest $request): RedirectResponse
    {
        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('profile.edit'));
    }
}
