<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\User;

/**
 * Authorizes actions related to viewing, creating, modifying, and engaging with chirps.
 */
class ChirpPolicy
{
    /**
     * Determines whether the caller can access the chirp index or feed.
     *
     * @param User|null $user The authenticated user, or null when the request is made by a guest.
     * @return bool Always true for public browsing of the chirp feed.
     */
    public function viewAll(?User $_user): bool
    {
        return true;
    }

    /**
     * Determines whether a user may create a new chirp.
     *
     * @param User $user The authenticated user attempting to create a chirp.
     * @return bool True when the user is allowed to create a chirp.
     */
    public function create(User $_user): bool
    {
        return true;
    }

    /**
     * Determines whether a user may update a given chirp.
     *
     * @param User $user The authenticated user performing the update.
     * @param Chirp $chirp The chirp being checked for modification rights.
     * @return bool True when the user is the author of the chirp.
     */
    public function update(User $user, Chirp $chirp): bool
    {
        return $chirp->user->is($user);
    }

    /**
     * Determines whether a user may delete a given chirp.
     *
     * @param User $user The authenticated user attempting to delete the chirp.
     * @param Chirp $chirp The chirp that will be checked for ownership.
     * @return bool True when the user owns the chirp and may delete it.
     */
    public function delete(User $user, Chirp $chirp): bool
    {
        return $chirp->user->is($user);
    }

    /**
     * Determines whether a user may like a chirp.
     *
     * @param User $user The authenticated user performing the like action.
     * @param Chirp $chirp The chirp being considered for a like.
     * @return bool True when the user has not already liked the chirp.
     */
    public function like(User $user, Chirp $chirp): bool
    {
        return ! $user->hasLikedChirp($chirp);
    }

    /**
     * Determines whether a user may toggle a bookmark on a chirp.
     *
     * @param User $user The authenticated user performing the bookmark action.
     * @param Chirp $chirp The chirp whose bookmark state is being evaluated.
     * @return bool True when the chirp is already bookmarked by the user.
     */
    public function bookmark(User $user, Chirp $chirp): bool
    {
        return $user->hasBookmarkedChirp($chirp);
    }
}
