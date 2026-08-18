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
        $result = [];

        switch ($request->method()) {
            case 'POST':
                $result = $this->like($chirp, $user);
                break;

            case 'DELETE':
                $result = $this->unlike($chirp, $user);
                break;
        }

        return back()->with(...$result);
    }

    /**
     * Like a chirp.
     *
     * @param Chirp $chirp
     * @param User $user
     * @return array{0: 'success'|'error', 1: string} $result
     * @throws UniqueConstraintViolationException
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
     * @param Chirp $chirp
     * @param User $user
     * @return array{0: 'success'|'error', 1: string} $result
     */
    private function unlike(Chirp $chirp, User $user): array
    {
        if (! $this->isLiked($chirp, $user)) {
            return ['error', 'You have not liked this chirp yet.'];
        }

        $chirp->likes()->where('user_id', $user->id)->delete();
        return ['success', 'You unliked this chirp.'];
    }

    /**
     * Check if a user has liked a chirp.
     *
     * @param Chirp $chirp
     * @param User $user
     * @return bool $isLiked
     */
    private function isLiked(Chirp $chirp, User $user): bool
    {
        return $chirp->likes()->where('user_id', $user->id)->exists();
    }
}
