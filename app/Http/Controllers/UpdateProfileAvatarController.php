<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileAvatarRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UpdateProfileAvatarController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateProfileAvatarRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $filename = $user->id.'.'.$request->file('avatar')->extension();

        $path = $request->file('avatar')->storeAs('avatars', $filename, 'public');

        $user->update(['avatar' => $path]);

        return back()->with('status', 'User avatar profile updated successfully.');
    }
}
