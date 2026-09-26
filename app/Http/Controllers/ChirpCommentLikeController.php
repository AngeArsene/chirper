<?php

namespace App\Http\Controllers;

use App\Contracts\Messageable;
use App\Enums\EngagementType;
use App\Http\Controllers\Abstract\EngagementController;
use App\Models\Chirp;
use App\Models\ChirpComment;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Override;

/**
 * Handles liking and unliking chirp comments for authenticated users.
 */
class ChirpCommentLikeController extends EngagementController
{
    /**
     * Returns the engagement type represented by this controller.
     *
     * @return EngagementType The like-specific engagement enum value.
     */
    #[Override]
    protected function engagementType(): EngagementType
    {
        return EngagementType::Like;
    }

    /**
     * Creates a like relationship between the user and the message.
     *
     * @param  User  $user  Authenticated user creating the like.
     * @param  Messageable  $message  Message that will receive the like.
     */
    #[Override]
    protected function attach(User $user, Messageable $message): void
    {
        $message->likes()->create(['user_id' => $user->id]);
    }

    /**
     * Removes the like relationship between the user and the message.
     *
     * @param  User  $user  Authenticated user removing the like.
     * @param  Messageable  $message  Message from which the like should be removed.
     */
    #[Override]
    protected function detach(User $user, Messageable $message): void
    {
        $message->likes()->whereBelongsTo($user)->delete();
    }

    /**
     * Handle the like or unlike action for a chirp comment based on the HTTP method.
     *
     * @param  Request  $request  The current HTTP request.
     * @param  Chirp  $chirp  The chirp associated with the comment.
     * @param  ChirpComment  $comment  The comment to be liked or unliked.
     * @param  User  $user  The currently authenticated user.
     */
    public function __invoke(Request $request, Chirp $chirp, ChirpComment $comment, #[CurrentUser] User $user): RedirectResponse
    {
        [$status, $message] = $this->toggleEngagement($request, $comment, $user);

        return back()->with($status, $message);
    }
}
