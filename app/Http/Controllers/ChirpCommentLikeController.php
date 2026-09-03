<?php

namespace App\Http\Controllers;

use App\Concerns\TogglesChirpEngagement;
use App\Contracts\Messageable;
use App\Enums\EngagementType;
use App\Models\Chirp;
use App\Models\ChirpComment;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Override;

class ChirpCommentLikeController extends Controller
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
     * @param  Messageable  $message  Chirp that will receive the like.
     */
    #[Override]
    private function attach(User $user, Messageable $message): void
    {
        $user->chirpCommentLikes()->create(['chirp_comment_id' => $message->id]);
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
        $user->chirpCommentLikes()->where('chirp_comment_id', $message->id)->delete();
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Chirp $chirp, ChirpComment $comment, #[CurrentUser] User $user): RedirectResponse
    {
        return back()->with(...$this->toggleEngagement($request, $comment, $user));
    }
}
