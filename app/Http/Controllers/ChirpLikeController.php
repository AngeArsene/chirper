<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

class ChirpLikeController extends Controller
{
    public function __invoke(Chirp $chirp, #[CurrentUser] User $user)
    {
        $deleted = $chirp->likes()->where('user_id', $user->id)->delete();

        if (! $deleted) {
            $chirp->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }
}
