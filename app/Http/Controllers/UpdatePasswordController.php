<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;

class UpdatePasswordController extends Controller
{
    /**
     * Update the authenticated user's password.
     */
    public function __invoke(UpdatePasswordRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        $user->update(['password' => $request->validated('password')]);

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
    }
}
