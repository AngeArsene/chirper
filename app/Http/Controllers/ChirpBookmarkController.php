<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\ChirpBookmark;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Handles listing, bookmarking, and unbookmarking chirps for authenticated users.
 */
class ChirpBookmarkController extends Controller
{
    /**
     * Display the authenticated user's bookmarked chirps with engagement data.
     *
     * @return View The rendered bookmarked chirps view.
     */
    public function index(): View
    {
        $chirps = Chirp::whereHas('bookmarks', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->with('user:id,name,email')
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_current_user' => fn ($query) => $query->where('user_id', Auth::id()),
            ])
            ->withExists([
                'bookmarks as bookmarked_by_current_user' => fn ($query) => $query->where('user_id', Auth::id()),
            ])
            ->addSelect([
                'bookmarked_at' => ChirpBookmark::select('created_at')
                    ->whereColumn('chirp_id', 'chirps.id')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->limit(1),
            ])
            ->withCasts(['bookmarked_at' => 'datetime'])
            ->orderByDesc('bookmarked_at')
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
        /**
         * @var array{0: 'success'|'error', 1: string} $result
         */
        $result = match ($request->method()) {
            'POST' => $this->bookmark($chirp, $user),
            'DELETE' => $this->unbookmark($chirp, $user),
            default => abort(405, 'Method not allowed'),
        };

        return back()->with(...$result);
    }

    /**
     * Create a bookmark for a chirp unless the user already has one.
     *
     * @param  Chirp  $chirp  The chirp to bookmark.
     * @param  User  $user  The user who owns the bookmark.
     * @return array{0: 'success'|'error', 1: string} A flash-message key and its user-facing message.
     */
    private function bookmark(Chirp $chirp, User $user): array
    {
        try {
            $user->bookmarkChirp($chirp);

            return ['success', 'You bookmarked this chirp.'];
        } catch (UniqueConstraintViolationException $_e) {
            return ['error', 'You already bookmarked this chirp.'];
        }
    }

    /**
     * Remove the user's bookmark from a chirp when one exists.
     *
     * @param  Chirp  $chirp  The chirp to unbookmark.
     * @param  User  $user  The user whose bookmark should be removed.
     * @return array{0: 'success'|'error', 1: string} A flash-message key and its user-facing message.
     */
    private function unbookmark(Chirp $chirp, User $user): array
    {
        if (! $user->hasBookmarkedChirp($chirp)) {
            return ['error', 'You have not bookmarked this chirp yet.'];
        }

        $user->unbookmarkChirp($chirp);

        return ['success', 'You unbookmarked this chirp.'];
    }
}
