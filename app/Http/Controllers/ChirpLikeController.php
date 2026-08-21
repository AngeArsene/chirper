<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Handles liking and unliking chirps for authenticated users.
 */
class ChirpLikeController extends Controller
{
    /**
     * Handle the like or unlike action for a chirp based on the HTTP method.
     *
     * @param  Request  $request  The current HTTP request.
     * @param  Chirp  $chirp  The chirp to be liked or unliked.
     * @param  User  $user  The currently authenticated user.
     *
     * @return RedirectResponse Redirect back with a success or error message.
     */
    public function __invoke(Request $request, Chirp $chirp, #[CurrentUser] User $user): RedirectResponse
    {
        /**
         * @var array{0: 'success'|'error', 1: string} $result
         */
        $result = match ($request->method()) {
            'POST' => $this->like($chirp, $user),
            'DELETE' => $this->unlike($chirp, $user),
            default => abort(405, 'Method not allowed'),
        };

        return back()->with(...$result);
    }

    /**
     * Like a chirp.
     *
     * @return array{0: 'success'|'error', 1: string}
     */
    private function like(Chirp $chirp, User $user): array
    {
        try {
            $user->likeChirp($chirp);

            return ['success', 'You liked this chirp.'];

        } catch (UniqueConstraintViolationException $_e) {
            return ['error', 'You already liked this chirp.'];
        }
    }

    /**
     * Unlike a chirp.
     *
     * @return array{0: 'success'|'error', 1: string}
     */
    private function unlike(Chirp $chirp, User $user): array
    {
        if (! $user->hasLikedChirp($chirp)) {
            return ['error', 'You have not liked this chirp yet.'];
        }

        $user->unlikeChirp($chirp);

        return ['success', 'You removed your like from this chirp.'];
    }
}
