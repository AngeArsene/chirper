<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Manages authenticated users' profile updates and account deletion.
 */
class UserProfileController extends Controller
{
    /**
     * Update the authenticated user's profile and reset email verification when needed.
     *
     * @param  UserProfileUpdateRequest  $request  The request containing validated profile fields.
     * @param  User  $profile  The authenticated profile being updated.
     * @return RedirectResponse A redirect to the profile page with a success message.
     *
     * @throws AuthorizationException If the request is not authorized.
     * @throws ValidationException If the name or email fails validation.
     */
    public function update(UserProfileUpdateRequest $request, #[CurrentUser] User $profile): RedirectResponse
    {
        $validated = $request->validated();

        $profile->name = $validated['name'];

        if ($profile->email !== $validated['email']) {
            $profile->email = $validated['email'];
            $profile->email_verified_at = null;
        }

        $profile->save();

        return to_route('profile.show')->with('success', 'Profile updated successfully.');
    }

    /**
     * Log out the authenticated user and permanently delete their account.
     *
     * @param  Request  $request  The current request whose session must be invalidated.
     * @param  User  $profile  The authenticated profile to delete.
     * @return RedirectResponse A redirect to the chirp feed with a success message.
     *
     * @throws AuthenticationException If no authenticated user is available.
     */
    public function destroy(Request $request, #[CurrentUser] User $profile): RedirectResponse
    {
        Auth::logout();

        $profile->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('chirps.index')->with('success', 'Your account has been deleted successfully.');
    }
}
