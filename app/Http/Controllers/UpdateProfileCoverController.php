<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Abstract\ProfileImageController;
use App\Http\Requests\UpdateProfileCoverRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Override;

/**
 * Handle profile cover image updates for the authenticated user.
 */
class UpdateProfileCoverController extends ProfileImageController
{
    /**
     * Identify the profile image attribute handled by this controller.
     *
     * @return string The user attribute containing the cover image path.
     */
    #[Override]
    protected function type(): string
    {
        return 'cover';
    }

    /**
     * Store the authenticated user's cover image and redirect back with the operation status.
     *
     * @param  UpdateProfileCoverRequest  $request  Validated request containing the cover image upload.
     * @param  User  $user  Authenticated user whose cover image is being updated.
     * @return RedirectResponse Redirect response carrying success or validation-style error feedback.
     */
    public function __invoke(UpdateProfileCoverRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        $result = $this->handle($request->cover, $user);

        return $result[0] === 'success' ? back()->with(...$result) : back()->withErrors($result);
    }
}
