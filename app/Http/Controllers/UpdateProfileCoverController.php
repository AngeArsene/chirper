<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileCoverRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateProfileCoverController extends Controller
{
    /**
     * Process the avatar upload, remove the previous image when needed, and redirect back with status feedback.
     *
     * @param  UpdateProfileCoverRequest  $request  Validated avatar upload request data.
     * @param  User  $user  Authenticated user whose avatar is being updated.
     * @return RedirectResponse Redirect response indicating whether the avatar update succeeded.
     */
    public function __invoke(UpdateProfileCoverRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        $oldPath = $user->cover;

        $path = $this->storeNewCover($request->cover);

        $oldPath = $this->deleteCurrentCover($oldPath, $path);

        return $this->updateUserCover($user, $path, $oldPath);
    }

    /**
     * Store the uploaded cover on the public disk and return its path.
     *
     * @param  UploadedFile  $cover  Uploaded file instance with an extension method.
     * @return string|null Stored cover path, or null when the file could not be persisted.
     */
    private function storeNewCover(UploadedFile $cover): ?string
    {
        $path = false;
        $filename = ((string) Str::uuid()).'.'.$cover->extension();

        $path = $cover->storeAs('covers', $filename, 'public');

        return $path ?: null;
    }

    /**
     * Remove the current cover from storage when a replacement was saved successfully.
     *
     * @param  string|null  $cover  Current cover path on the user record.
     * @param  string|null  $newCoverStored  Newly stored cover path used to determine whether an old file should be removed.
     * @return string|null Null when the old file was deleted, otherwise the previous cover path to retain.
     */
    private function deleteCurrentCover(?string $cover, ?string $newCoverStored): ?string
    {
        $deleted = false;

        if ($cover && $newCoverStored) {
            $deleted = Storage::disk('public')->delete($cover);
        }

        return $deleted ? null : $cover;
    }

    /**
     * Persist the stored cover path or retain the previous cover when the upload fails.
     *
     * @param  User  $user  User whose profile image is being updated.
     * @param  string|null  $path  Newly stored cover path, if available.
     * @param  string|null  $oldPath  Existing cover path to restore on failure.
     * @return RedirectResponse Redirect back with either a success flash or validation error.
     */
    private function updateUserCover(User $user, ?string $path, ?string $oldPath): RedirectResponse
    {
        if ($path) {
            $user->update(['cover' => $path]);

            return back()->with('success', 'User profile cover updated successfully.');
        }

        $user->update(['cover' => $oldPath]);

        return back()->withErrors(['cover' => 'Something went wrong please try again.']);
    }
}
