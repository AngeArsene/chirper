<?php

namespace App\Models;

use App\Contracts\Messageable;
use App\Enums\MessageableType;
use Database\Factories\ChirpCommentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a comment added to a chirp.
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $chirp_id
 * @property-read string $message
 * @property-read string|null $idempotency_key
 * @property-read \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @property-read Chirp $chirp
 */
#[Fillable(['user_id', 'chirp_id', 'message', 'idempotency_key'])]
class ChirpComment extends Model implements Messageable
{
    /** @use HasFactory<ChirpCommentFactory> */
    use HasFactory;

    /**
     * Get the type of messageable entity.
     *
     * @return MessageableType The type of messageable entity.
     */
    public function type(): MessageableType
    {
        return MessageableType::Comment;
    }

    /**
     * Resolve the user who authored the comment.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Resolve the chirp this comment belongs to.
     *
     * @return BelongsTo<Chirp, $this>
     */
    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }

    /**
     * Resolve the likes associated with this comment.
     *
     * @return HasMany<ChirpCommentLike, $this>
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ChirpCommentLike::class);
    }
}
