<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChirpLikeController extends Controller
{
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
            $chirp->likes()->create(['user_id' => $user->id]);
            return ['success', 'You liked this chirp.'];
        } catch (UniqueConstraintViolationException $e) {
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
        if (! $chirp->isLikedBy($user)) {
            return ['error', 'You have not liked this chirp yet.'];
        }

        $chirp->likes()->where('user_id', $user->id)->delete();
        return ['success', 'You removed your like from this chirp.'];
    }
}
