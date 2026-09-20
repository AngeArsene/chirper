<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileAvatarRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Handle profile avatar updates for the authenticated user.
 */
class UpdateProfileAvatarController extends Controller
{
    /**
     * Process the avatar upload, remove the previous image when needed, and redirect back with status feedback.
     *
     * @param  UpdateProfileAvatarRequest  $request  Validated avatar upload request data.
     * @param  User  $user  Authenticated user whose avatar is being updated.
     * @return RedirectResponse Redirect response indicating whether the avatar update succeeded.
     */
    public function __invoke(UpdateProfileAvatarRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        $oldPath = $user->avatar;

        $path = $this->storeNewAvatar($request->avatar);

        $oldPath = $this->deleteCurrentAvatar($oldPath, $path);

        return $this->updateUserAvatar($user, $path, $oldPath);
    }

    /**
     * Store the uploaded avatar on the public disk and return its path.
     *
     * @param  mixed  $avatar  Uploaded file instance with an extension method.
     * @return string|null Stored avatar path, or null when the file could not be persisted.
     */
    private function storeNewAvatar(mixed $avatar): ?string
    {
        $path = false;
        $filename = ((string) Str::uuid()) . '.' . $avatar->extension();

        $path = $avatar->storeAs('avatars', $filename, 'public');

        return $path ?: null;
    }

    /**
     * Remove the current avatar from storage when a replacement was saved successfully.
     *
     * @param  string|null  $avatar  Current avatar path on the user record.
     * @param  string|null  $newAvatarStored  Newly stored avatar path used to determine whether an old file should be removed.
     * @return string|null Null when the old file was deleted, otherwise the previous avatar path to retain.
     */
    private function deleteCurrentAvatar(?string $avatar, ?string $newAvatarStored): ?string
    {
        $deleted = false;

        if ($avatar && $newAvatarStored) {
            $deleted = Storage::disk('public')->delete($avatar);
        }

        return $deleted ? null : $avatar;
    }

    /**
     * Persist the stored avatar path or retain the previous avatar when the upload fails.
     *
     * @param  User  $user  User whose profile image is being updated.
     * @param  string|null  $path  Newly stored avatar path, if available.
     * @param  string|null  $oldPath  Existing avatar path to restore on failure.
     * @return RedirectResponse Redirect back with either a success flash or validation error.
     */
    private function updateUserAvatar(User $user, ?string $path, ?string $oldPath): RedirectResponse
    {
        if ($path) {
            $user->update(['avatar' => $path]);

            return back()->with('success', 'User avatar profile updated successfully.');
        }

        $user->update(['avatar' => $oldPath]);

        return back()->withErrors(['avatar' => 'Something went wrong please try again.']);
    }
}
