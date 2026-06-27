<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;
use Laravel\Mcp\Request;

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

        return to_route('profile.show')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HttpRequest $request, #[CurrentUser] User $profile): RedirectResponse
    {
        $profile->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('chirps.index')->with('success', 'Your account has been deleted successfully.');
    }
}
