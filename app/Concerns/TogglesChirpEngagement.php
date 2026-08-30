<?php

namespace App\Concerns;

use App\Enums\EngagementType;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;

/**
 * Provides the shared request-to-flash-message flow for chirp engagement toggles.
 *
 * The trait centralizes the POST/DELETE decision tree so engagement
 * controllers can share the same semantics while remaining type-specific.
 */
trait TogglesChirpEngagement
{
    /**
     * Returns the engagement type handled by the concrete controller.
     *
     * @return EngagementType The specific engagement variant such as a like or bookmark.
     */
    abstract private function type(): EngagementType;

    /**
     * Persists a new engagement record for the user and chirp.
     *
     * @param  User  $user  Authenticated user creating the engagement.
     * @param  Chirp  $chirp  Chirp receiving the engagement.
     */
    abstract private function attach(User $user, Chirp $chirp): void;

    /**
     * Removes the engagement record between the user and the chirp.
     *
     * @param  User  $user  Authenticated user removing the engagement.
     * @param  Chirp  $chirp  Chirp from which the engagement should be removed.
     */
    abstract private function detach(User $user, Chirp $chirp): void;

    /**
     * Routes the request method to the appropriate engagement action.
     *
     * @param  Request  $request  Incoming HTTP request containing the verb that determines the action.
     * @param  Chirp  $chirp  Chirp being acted on.
     * @param  User  $user  Authenticated user performing the action.
     * @return array{0: 'success'|'error', 1: string} A flash-message tuple in the form [key, message].
     */
    private function toggleEngagement(Request $request, Chirp $chirp, User $user): array
    {
        return match ($request->method()) {
            'POST' => $this->runAttach($user, $chirp),
            'DELETE' => $this->runDetach($user, $chirp),
            default => abort(405, 'Method not allowed'),
        };
    }

    /**
     * Attempts to attach an engagement and translates duplicate inserts into a friendly flash message.
     *
     * @param  User  $user  Authenticated user creating the engagement.
     * @param  Chirp  $chirp  Chirp receiving the engagement.
     * @return array{0: 'success'|'error', 1: string} A flash-message tuple in the form [key, message].
     */
    private function runAttach(User $user, Chirp $chirp): array
    {
        try {
            $this->attach($user, $chirp);

            return ['success', "You {$this->type()->pastTense()} this chirp."];
        } catch (UniqueConstraintViolationException) {
            return ['error', "You already {$this->type()->pastTense()} this chirp."];
        }
    }

    /**
     * Removes an engagement only when it exists and returns a human-readable result for the UI.
     *
     * @param  User  $user  Authenticated user removing the engagement.
     * @param  Chirp  $chirp  Chirp from which the engagement should be removed.
     * @return array{0: 'success'|'error', 1: string} A flash-message tuple in the form [key, message].
     */
    private function runDetach(User $user, Chirp $chirp): array
    {
        if ($user->can($this->type()->value, $chirp)) {
            return ['error', "You have not {$this->type()->pastTense()} this chirp yet."];
        }

        $this->detach($user, $chirp);

        return ['success', "You un{$this->type()->pastTense()} this chirp."];
    }
}
