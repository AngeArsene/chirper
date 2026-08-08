<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

/**
 * Handles a profile password-change request submitted through the password edit route.
 */
class UserPasswordUpdate extends Controller
{
    /**
     * Updates the authenticated user's password and returns to the profile password view.
     *
     * @param  UserPasswordUpdateRequest  $request  A validated profile password-change request.
     * @return RedirectResponse Redirects to the profile password page with a success message.
     *
     * @throws ValidationException If the incoming request payload fails the `UserPasswordUpdateRequest` rules.
     */
    public function __invoke(UserPasswordUpdateRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => $request->validated('password'),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
    }
}
