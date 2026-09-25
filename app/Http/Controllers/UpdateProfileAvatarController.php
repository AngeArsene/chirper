<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileAvatarRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Override;

/**
 * Handle profile avatar updates for the authenticated user.
 */
class UpdateProfileAvatarController extends ProfileImageController
{
    /**
     * Identify the profile image attribute handled by this controller.
     *
     * @return string The user attribute containing the avatar path.
     */
    #[Override]
    protected function type(): string
    {
        return 'avatar';
    }

    /**
     * Store the authenticated user's avatar and redirect back with the operation status.
     *
     * @param  UpdateProfileAvatarRequest  $request  Validated request containing the avatar upload.
     * @param  User  $user  Authenticated user whose avatar is being updated.
     * @return RedirectResponse Redirect response carrying success or validation-style error feedback.
     */
    public function __invoke(UpdateProfileAvatarRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        $result = $this->handle($request->avatar, $user);

        return $result[0] === 'success' ? back()->with(...$result) : back()->withErrors($result);
    }
}
