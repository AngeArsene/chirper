<?php

namespace App\Http\Controllers;

use App\Concerns\TogglesChirpEngagement;
use App\Contracts\Messageable;
use App\Enums\EngagementType;
use App\Models\Chirp;
use App\Models\User;
use App\Pipelines\WhereUserHasRelation;
use App\Pipelines\WithBookmarkedAtColumn;
use App\Pipelines\WithChirpAuthor;
use App\Pipelines\WithEngagementCount;
use App\Pipelines\WithUserEngagementFlag;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\View\View;
use Override;

/**
 * Handles listing, bookmarking, and unbookmarking chirps for authenticated users.
 */
class ChirpBookmarkController extends Controller
{
    use TogglesChirpEngagement;

    /**
     * Returns the engagement type represented by this controller.
     *
     * @return EngagementType The bookmark-specific engagement enum value.
     */
    #[Override]
    private function type(): EngagementType
    {
        return EngagementType::Bookmark;
    }

    /**
     * Creates a bookmark relationship between the user and the chirp.
     *
     * @param  User  $user  Authenticated user creating the bookmark.
     * @param  Messageable  $message  Chirp that receives the bookmark.
     */
    #[Override]
    private function attach(User $user, Messageable $message): void
    {
        $user->chirpBookmarks()->create(['chirp_id' => $message->id]);
    }

    /**
     * Removes the bookmark relationship between the user and the chirp.
     *
     * @param  User  $user  Authenticated user removing the bookmark.
     * @param  Messageable  $message  Chirp from which the bookmark should be removed.
     */
    #[Override]
    private function detach(User $user, Messageable $message): void
    {
        $user->chirpBookmarks()->whereBelongsTo($message)->delete();
    }

    /**
     * Lists the authenticated user's bookmarked chirps with author and engagement metadata.
     *
     * @return View The rendered view containing the paginated bookmarks list.
     */
    public function index(): View
    {
        $chirps = Pipeline::send(Chirp::query())
            ->through([
                new WithChirpAuthor,
                new WithBookmarkedAtColumn,
                new WhereUserHasRelation(EngagementType::Bookmark),
                new WithEngagementCount(EngagementType::Like, EngagementType::Comment),
                new WithUserEngagementFlag(EngagementType::Like, EngagementType::Bookmark),
            ])
            ->thenReturn()
            ->latest('bookmarked_at')
            ->paginate(10);

        return $this->resolve_view(compact('chirps'));
    }

    /**
     * Add or remove a chirp bookmark according to the HTTP method.
     *
     * @param  Request  $request  The current HTTP request.
     * @param  Chirp  $chirp  The chirp to bookmark or unbookmark, resolved from the route.
     * @param  User  $user  The currently authenticated user.
     * @return RedirectResponse A redirect back to the previous page with an operation result message.
     */
    public function toggle(Request $request, Chirp $chirp, #[CurrentUser] User $user): RedirectResponse
    {
        return back()->with(...$this->toggleEngagement($request, $chirp, $user));
    }
}
