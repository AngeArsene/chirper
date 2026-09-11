<?php

namespace App\Models;

use Database\Factories\LikeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * Represents a "like" action by a user on various likeable entities.
 *
 * @property-read int $id
 * @property int $user_id
 * @property int $likeable_id
 * @property string $likeable_type
 * @property-read Carbon|null $created_at
 * @property-read Carbon|null $updated_at
 * @property-read User $user
 * @property-read Model $likeable
 */
#[Fillable('user_id', 'likeable_id', 'likeable_type')]
class Like extends Model
{
    /** @use HasFactory<LikeFactory> */
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    const UPDATED_AT = null;

    /**
     * Get the user who performed the like action.
     *
     * @return BelongsTo<User, $this> The user associated with this like.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the likeable entity that this like is associated with.
     *
     * @return MorphTo The likeable entity associated with this like.
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
