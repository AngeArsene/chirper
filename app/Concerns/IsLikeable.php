<?php

namespace App\Concerns;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Provides a shared interface for models that can be liked by a user.
 *
 * This trait allows models to define a polymorphic relationship with the Like model,
 * enabling users to like various types of content within the application.
 *
 * @mixin Model
 */
trait IsLikeable
{
    /**
     * Get the likes associated with this model.
     *
     * @return MorphMany<Like, $this>
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Resolve the user who authored the like.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
