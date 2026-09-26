<?php

namespace App\Http\Controllers\Abstract;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Coordinate storage and persistence for profile images.
 */
abstract class ProfileImageController extends Controller
{
    /**
     * Return the profile image attribute handled by this controller.
     *
     * @return string
     */
    abstract protected function type(): string;

    /**
     * Store a profile image and prepare the update result.
     *
     * @param UploadedFile $image
     * @param User $user
     * @return array<int|string, string>
     */
    protected function handle(UploadedFile $image, User $user): array
    {
        $oldPath = $user->{$this->type()};

        $path = $this->storeNewImage($image, "{$this->type()}s");

        $oldPath = $this->deleteCurrentImage($oldPath, $path);

        return $this->updateUserImage($user, $path, $oldPath);
    }

    /**
     * Store the uploaded image and return its public path.
     *
     * @param UploadedFile $image
     * @param string $folder
     * @return string|null
     */
    private function storeNewImage(UploadedFile $image, string $folder): ?string
    {
        $path = false;
        $filename = ((string) Str::uuid()).'.'.$image->extension();

        $path = $image->storeAs($folder, $filename, 'public');

        return $path ?: null;
    }

    /**
     * Remove the current image when a replacement was stored.
     *
     * @param string|null $image
     * @param string|null $newImageStored
     * @return string|null
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
     * Persist the stored image path or restore the previous one.
     *
     * @param User $user
     * @param string|null $path
     * @param string|null $oldPath
     * @return array<int|string, string>
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
