<?php

namespace App\Http\Controllers\Abstract;

use App\Contracts\Messageable;
use App\Enums\EngagementType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

abstract class EngagementController extends Controller
{
    /**
     * Return the engagement type for this controller.
     *
     * @return EngagementType
     */
    abstract protected function engagementType(): EngagementType;

    /**
     * Persist a user engagement for a message.
     *
     * @param User $user
     * @param Messageable $message
     */
    abstract protected function attach(User $user, Messageable $message): void;

    /**
     * Remove a user engagement from a message.
     *
     * @param User $user
     * @param Messageable $message
     */
    abstract protected function detach(User $user, Messageable $message): void;

    /**
     * Toggle the engagement for the current request.
     *
     * @param Request $request
     * @param Messageable $message
     * @param User $user
     * @return array{0: 'success'|'error', 1: string}
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
     * Attach the engagement and translate duplicate inserts.
     *
     * @param User $user
     * @param Messageable $message
     * @return array{0: 'success'|'error', 1: string}
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
     * Remove the engagement and return a user-readable result.
     *
     * @param User $user
     * @param Messageable $message
     * @return array{0: 'success'|'error', 1: string}
     * @throws \LogicException
     */
    private function runDetach(User $user, Messageable $message): array
    {
        $ability = $this->engagementType()->value;
        $policy = Gate::getPolicyFor($message);

        if (! method_exists($policy ?? '', $ability)) {
            throw new \LogicException("No policy method defined for {$ability} on ".get_class($message));
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
