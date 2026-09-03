<?php

namespace App\Policies;

use App\Models\ChirpComment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Authorizes viewing, creating, updating, and deleting chirp comments.
 */
class ChirpCommentPolicy
{
    /**
     * Allow any authenticated user to view comment collections.
     *
     * @param User $_user The user requesting access to the collection.
     * @return bool Always true for the current application policy.
     */
    public function viewAll(User $_user): bool
    {
        return true;
    }

    /**
     * Allow any authenticated user to create a comment.
     *
     * @param User $_user The user attempting to create the comment.
     * @return bool Always true for the current application policy.
     */
    public function create(User $_user): bool
    {
        return true;
    }

    /**
     * Allow the owning user to edit a comment.
     *
     * @param User $user The authenticated user performing the update.
     * @param ChirpComment $chirpComment The comment being updated.
     * @return bool True when the author matches the authenticated user.
     */
    public function update(User $user, ChirpComment $chirpComment): bool
    {
        return $chirpComment->user->is($user);
    }

    /**
     * Allow the owning user to remove a comment.
     *
     * @param User $user The authenticated user performing the deletion.
     * @param ChirpComment $chirpComment The comment being removed.
     * @return bool True when the author matches the authenticated user.
     */
    public function delete(User $user, ChirpComment $chirpComment): bool
    {
        return $chirpComment->user->is($user);
    }

    /**
     * Allow a user to like a comment if they haven't already.
     *
     * @param User $user The authenticated user attempting to like the comment.
     * @param ChirpComment $chirpComment The comment being liked.
     * @return bool True when the user has not previously liked the comment.
     */
    public function like(User $user, ChirpComment $chirpComment): bool
    {
        return ! $user->chirpCommentLikes()->whereBelongsTo($chirpComment)->exists();
    }
}
