<?php

namespace App\Http\Controllers;

use App\Contracts\Messageable;
use App\Enums\EngagementType;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

abstract class EngagementController extends Controller
{
    /**
     * Get the type of engagement for this model.
     *
     * @return EngagementType The type of engagement for this model.
     */
    abstract protected function engagementType(): EngagementType;

    /**
     * Persists a new engagement record for the user and message.
     *
     * @param  User  $user  Authenticated user creating the engagement.
     * @param  Messageable  $message  Message receiving the engagement.
     */
    abstract protected function attach(User $user, Messageable $message): void;

    /**
     * Removes the engagement record between the user and the message.
     *
     * @param  User  $user  Authenticated user removing the engagement.
     * @param  Messageable  $message  Message from which the engagement should be removed.
     */
    abstract protected function detach(User $user, Messageable $message): void;

    /**
     * Routes the request method to the appropriate engagement action.
     *
     * @param  Request  $request  Incoming HTTP request containing the verb that determines the action.
     * @param  Messageable  $message  Message being acted on.
     * @param  User  $user  Authenticated user performing the action.
     * @return array{0: 'success'|'error', 1: string} A flash-message tuple in the form [key, message].
     */
    protected function toggleEngagement(Request $request, Messageable $message, User $user): array
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
        $pastTenseVerb = $this->engagementType()->pastTense();
        $messageType = $message->messageableType()->value;

        try {
            $this->attach($user, $message);

            return ['success', "You {$pastTenseVerb} this {$messageType}."];
        } catch (UniqueConstraintViolationException) {
            return ['error', "You have already {$pastTenseVerb} this {$messageType}."];
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

        if (! method_exists($policy ?? '', $ability)) {
            throw new \LogicException("No policy method defined for {$ability} on " . get_class($message));
        }

        $pastTenseVerb = $this->engagementType()->pastTense();
        $messageType = $message->messageableType()->value;

        if ($user->can($ability, $message)) {
            return ['error', "You have not {$pastTenseVerb} this {$messageType} yet."];
        }

        $this->detach($user, $message);

        return ['success', "You un{$pastTenseVerb} this {$messageType}."];
    }
}
