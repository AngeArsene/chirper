<?php

namespace App\Http\Controllers;

use App\Concerns\TogglesChirpEngagement;
use App\Contracts\Messageable;
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

    /**
     * Returns the engagement type represented by this controller.
     *
     * @return EngagementType The like-specific engagement enum value.
     */
    #[Override]
    private function type(): EngagementType
    {
        return EngagementType::Like;
    }

    /**
     * Creates a like relationship between the user and the chirp.
     *
     * @param  User  $user  Authenticated user creating the like.
     * @param  Messageable $message Chirp that will receive the like.
     */
    #[Override]
    private function attach(User $user, Messageable $message): void
    {
        $user->chirpLikes()->create(['chirp_id' => $message->id]);
    }

    /**
     * Removes the like relationship between the user and the chirp.
     *
     * @param  User  $user  Authenticated user removing the like.
     * @param  Messageable  $message  Chirp from which the like should be removed.
     */
    #[Override]
    private function detach(User $user, Messageable $message): void
    {
        $user->chirpLikes()->whereBelongsTo($message)->delete();
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
