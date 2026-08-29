<?php

namespace App\Http\Controllers;

use App\Concerns\TogglesChirpEngagement;
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
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Handles listing, bookmarking, and unbookmarking chirps for authenticated users.
 */
class ChirpBookmarkController extends Controller
{
    use TogglesChirpEngagement;

    #[Override]
    private function type(): EngagementType
    {
        return EngagementType::Bookmark;
    }

    #[Override]
    private function has(User $user, Chirp $chirp): bool
    {
        return $user->hasBookmarkedChirp($chirp);
    }

    #[Override]
    private function attach(User $user, Chirp $chirp): void
    {
        $user->bookmarkChirp($chirp);
    }

    #[Override]
    private function detach(User $user, Chirp $chirp): void
    {
        $user->unbookmarkChirp($chirp);
    }

    /**
     * Display the authenticated user's bookmarked chirps with engagement data.
     *
     * @return View The rendered bookmarked chirps view.
     */
    public function index(): View
    {
        $chirps = Pipeline::send(Chirp::query())
            ->through([
                new WithChirpAuthor,
                new WithBookmarkedAtColumn,
                new WithEngagementCount(EngagementType::Like),
                new WithUserEngagementFlag(EngagementType::Like),
                new WhereUserHasRelation(EngagementType::Bookmark),
                new WithUserEngagementFlag(EngagementType::Bookmark),
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
     *
     * @throws HttpException If the request method is not POST or DELETE.
     */
    public function toggle(Request $request, Chirp $chirp, #[CurrentUser] User $user): RedirectResponse
    {
        return back()->with(...$this->toggleEngagement($request, $chirp, $user));
    }
}
