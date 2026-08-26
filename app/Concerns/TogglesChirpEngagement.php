<?php

namespace App\Concerns;

use App\Enums\EngagementType;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;

trait TogglesChirpEngagement
{
    abstract private function type(): EngagementType;

    abstract private function has(User $user, Chirp $chirp): bool;

    abstract private function attach(User $user, Chirp $chirp): void;

    abstract private function detach(User $user, Chirp $chirp): void;

    /**
     *
     *
     * @return array{0: 'success'|'error', 1: string} A flash-message key and its user-facing message.
     */
    private function toggleEngagement(Request $request, Chirp $chirp, User $user): array
    {
        return match ($request->method()) {
            'POST' => $this->attachEngagement($user, $chirp),
            'DELETE' => $this->detachEngagement($user, $chirp),
            default => abort(405, 'Method not allowed'),
        };
    }

    /**
     *
     *
     * @param  User  $user
     * @param  Chirp  $chirp
     * @return array{0: 'success'|'error', 1: string} A flash-message key and its user-facing message.
     */
    private function attachEngagement(User $user, Chirp $chirp): array
    {
        try {
            $this->attach($user, $chirp);

            return ['success', "You {$this->type()->pastTenseVerb()} this chirp."];
        } catch (UniqueConstraintViolationException) {
            return ['error', "You already {$this->type()->pastTenseVerb()} this chirp."];
        }
    }

    /**
     *
     *
     * @param  Chirp  $chirp
     * @param  User  $user
     * @return array{0: 'success'|'error', 1: string} A flash-message key and its user-facing message.
     */
    private function detachEngagement(User $user, Chirp $chirp): array
    {
        if (! $this->has($user, $chirp)) {
            return ['error', "You have not {$this->type()->pastTenseVerb()} this chirp yet."];
        }

        $this->detach($user, $chirp);

        return ['success', "You un{$this->type()->pastTenseVerb()} this chirp."];
    }
}
