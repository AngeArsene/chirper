<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UserProfileUpdateRequest $request, User $user)
    {
        $request->validated();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
