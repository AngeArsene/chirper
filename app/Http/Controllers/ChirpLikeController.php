<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\UniqueConstraintViolationException;

class ChirpLikeController extends Controller
{
    public function __invoke(Chirp $chirp, #[CurrentUser] User $user)
    {
        try {
            // Most common path: Create a like
            $chirp->likes()->create(['user_id' => $user->id]);
        } catch (UniqueConstraintViolationException $e) {
            // Less common path: Remove the existing like
            $chirp->likes()->where('user_id', $user->id)->delete();
        }

        return back();
    }
}
