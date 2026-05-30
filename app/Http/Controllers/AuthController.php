<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function sign_up()
    {
        return $this->resolve_view();
    }

    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());

        Auth::login($user);

        return redirect()
            ->route('chirps.index')
            ->with('success', 'Account created successfully!');
    }
}
