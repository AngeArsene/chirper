<?php

namespace App\Http\Controllers;

use App\Concerns\TogglesChirpEngagement;
use App\Enums\EngagementType;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Override;

/**
 * Handles liking and unliking chirps for authenticated users.
 */
class ChirpLikeController extends Controller
{
    use TogglesChirpEngagement;

    #[Override]
    private function type(): EngagementType
    {
        return EngagementType::Like;
    }

    #[Override]
    private function has(User $user, Chirp $chirp): bool
    {
        return $user->hasLikedChirp($chirp);
    }

    #[Override]
    private function attach(User $user, Chirp $chirp): void
    {
        $user->likeChirp($chirp);
    }

    #[Override]
    private function detach(User $user, Chirp $chirp): void
    {
        $user->unlikeChirp($chirp);
    }

    /**
     * Handle the like or unlike action for a chirp based on the HTTP method.
     *
     * @param  Request  $request  The current HTTP request.
     * @param  Chirp  $chirp  The chirp to be liked or unliked.
     * @param  User  $user  The currently authenticated user.
     * @return RedirectResponse Redirect back with a success or error message.
     */
    public function __invoke(Request $request, Chirp $chirp, #[CurrentUser] User $user): RedirectResponse
    {
        return back()->with(...$this->toggleEngagement($request, $chirp, $user));
    }
}
