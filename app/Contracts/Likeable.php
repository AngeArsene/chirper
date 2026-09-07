<?php

namespace App\Contracts;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Defines a contract for models that can be liked by a user.
 */
interface Likeable
{
    /**
     * Get the likes associated with this model.
     *
     * @return MorphMany<Like, $this>
     */
    public function likes(): MorphMany;

    /**
     * Resolve the user who authored the like.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo;
}
