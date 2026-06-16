<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UserProfileUpdateRequest $request, #[CurrentUser] User $profile): RedirectResponse
    {
        $validated = $request->validated();

        $profile->name = $validated['name'];
        $profile->email = $validated['email'];

        if (!empty($validated['password'])) {
            $profile->password = Hash::make($validated['password']);
        }

        $profile->save();

        return back()->with('success', __('Profile updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
