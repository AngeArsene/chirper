<?php

namespace App\Concerns;

use App\Contracts\Messageable;
use App\Enums\EngagementType;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * Provides the shared request-to-flash-message flow for chirp engagement toggles.
 *
 * The trait centralizes the POST/DELETE decision tree so engagement
 * controllers can share the same semantics while remaining type-specific.
 */
trait TogglesEngagement
{
    /**
     * Get the type of engagement for this model.
     *
     * @return EngagementType The type of engagement for this model.
     */
    abstract private function engagementType(): EngagementType;

    /**
     * Persists a new engagement record for the user and message.
     *
     * @param  User  $user  Authenticated user creating the engagement.
     * @param  Messageable  $message  Message receiving the engagement.
     */
    abstract private function attach(User $user, Messageable $message): void;

    /**
     * Removes the engagement record between the user and the message.
     *
     * @param  User  $user  Authenticated user removing the engagement.
     * @param  Messageable  $message  Message from which the engagement should be removed.
     */
    abstract private function detach(User $user, Messageable $message): void;

    /**
     * Routes the request method to the appropriate engagement action.
     *
     * @param  Request  $request  Incoming HTTP request containing the verb that determines the action.
     * @param  Messageable  $message  Message being acted on.
     * @param  User  $user  Authenticated user performing the action.
     * @return array{0: 'success'|'error', 1: string} A flash-message tuple in the form [key, message].
     */
    private function toggleEngagement(Request $request, Messageable $message, User $user): array
    {
        return match ($request->method()) {
            'POST' => $this->runAttach($user, $message),
            'DELETE' => $this->runDetach($user, $message),
            default => abort(405, 'Method not allowed'),
        };
    }

    /**
     * Attempts to attach an engagement and translates duplicate inserts into a friendly flash message.
     *
     * @param  User  $user  Authenticated user creating the engagement.
     * @param  Messageable  $message  Message receiving the engagement.
     * @return array{0: 'success'|'error', 1: string} A flash-message tuple in the form [key, message].
     */
    private function runAttach(User $user, Messageable $message): array
    {
        try {
            $this->attach($user, $message);

            return [
                'success',
                "You {$this->engagementType()->pastTense()} this {$message->messageableType()->value}.",
            ];
        } catch (UniqueConstraintViolationException) {
            return [
                'error',
                "You have already {$this->engagementType()->pastTense()} this {$message->messageableType()->value}.",
            ];
        }
    }

    /**
     * Removes an engagement only when it exists and returns a human-readable result for the UI.
     *
     * @param  User  $user  Authenticated user removing the engagement.
     * @param  Messageable  $message  Message from which the engagement should be removed.
     * @return array{0: 'success'|'error', 1: string} A flash-message tuple in the form [key, message].
     *
     * @throws \LogicException If the policy method for the engagement type is not defined on the message.
     */
    private function runDetach(User $user, Messageable $message): array
    {
        $ability = $this->engagementType()->value;
        $policy = Gate::getPolicyFor($message);

        if (is_null($policy) || ! method_exists($policy, $ability)) {
            throw new \LogicException("No policy method defined for {$ability} on ".get_class($message));
        }

        if ($user->can($ability, $message)) {
            return [
                'error',
                "You have not {$this->engagementType()->pastTense()} this {$message->messageableType()->value} yet.",
            ];
        }

        $this->detach($user, $message);

        return [
            'success',
            "You un{$this->engagementType()->pastTense()} this {$message->messageableType()->value}.",
        ];
    }
}
