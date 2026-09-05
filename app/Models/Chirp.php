<?php

namespace App\Models;

use App\Contracts\Messageable;
use App\Enums\MessageableType;
use Database\Factories\ChirpFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Represents a short user-authored message published to the timeline.
 *
 * @property-read int $id
 * @property-read string $message
 * @property-read string|null $idempotency_key
 * @property-read Carbon|null $created_at
 * @property-read Carbon|null $updated_at
 * @property-read User $user
 */
#[Fillable(['message', 'idempotency_key'])]
class Chirp extends Model implements Messageable
{
    /** @use HasFactory<ChirpFactory> */
    use HasFactory;

    /**
     * Get the type of messageable entity.
     *
     * @return MessageableType The type of messageable entity.
     */
    public function type(): MessageableType
    {
        return MessageableType::Chirp;
    }

    /**
     * Get the user that owns the chirp.
     *
     * @return BelongsTo<User, $this> The user who authored the chirp.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the chirp likes owned by the chirp.
     *
     * @return HasMany<ChirpLike, $this>
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ChirpLike::class);
    }

    /**
     * Get the bookmarks belonging to this chirp.
     *
     * @return HasMany<ChirpBookmark, $this>
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(ChirpBookmark::class);
    }

    /**
     * Resolve the comments attached to the chirp.
     *
     * @return HasMany<ChirpComment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ChirpComment::class);
    }
}
