<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Coordinate storage and persistence for authenticated users' profile images.
 */
abstract class ProfileImageController extends Controller
{
    /**
     * Return the user attribute and storage resource name for the profile image.
     *
     * @return string Profile image attribute handled by the concrete controller.
     */
    abstract protected function type(): string;

    /**
     * Store a profile image, remove its replaced file, and prepare the update status.
     *
     * @param  UploadedFile  $image  Uploaded profile image to store.
     * @param  User  $user  User whose profile image is being updated.
     * @return array<int|string, string> Status payload containing a success message or an image-specific error.
     */
    protected function handle(UploadedFile $image, User $user): array
    {
        $oldPath = $user->{$this->type()};

        $path = $this->storeNewImage($image, "{$this->type()}s");

        $oldPath = $this->deleteCurrentImage($oldPath, $path);

        return $this->updateUserImage($user, $path, $oldPath);
    }

    /**
     * Store the uploaded image on the public disk and return its path.
     *
     * @param  UploadedFile  $image  Uploaded file instance with an extension method.
     * @param  string  $folder  Public storage folder in which to place the image.
     * @return string|null Stored image path, or null when the file could not be persisted.
     */
    private function storeNewImage(UploadedFile $image, string $folder): ?string
    {
        $path = false;
        $filename = ((string) Str::uuid()).'.'.$image->extension();

        $path = $image->storeAs($folder, $filename, 'public');

        return $path ?: null;
    }

    /**
     * Remove the current image from storage when a replacement was saved successfully.
     *
     * @param  string|null  $image  Current image path on the user record.
     * @param  string|null  $newImageStored  Newly stored image path used to determine whether an old file should be removed.
     * @return string|null Null when the old file was deleted, otherwise the previous image path to retain.
     */
    private function deleteCurrentImage(?string $image, ?string $newImageStored): ?string
    {
        $deleted = false;

        if ($image && $newImageStored) {
            $deleted = Storage::disk('public')->delete($image);
        }

        return $deleted ? null : $image;
    }

    /**
     * Persist the stored image path or retain the previous image when the upload fails.
     *
     * @param  User  $user  User whose profile image is being updated.
     * @param  string|null  $path  Newly stored image path, if available.
     * @param  string|null  $oldPath  Existing image path to restore on failure.
     * @return array<int|string, string> Status payload containing a success message or an image-specific error.
     */
    private function updateUserImage(User $user, ?string $path, ?string $oldPath): array
    {
        if ($path) {
            $user->update([$this->type() => $path]);

            return ['success', "User profile {$this->type()} updated successfully."];
        }

        $user->update([$this->type() => $oldPath]);

        return [$this->type() => 'Something went wrong please try again.'];
    }
}
