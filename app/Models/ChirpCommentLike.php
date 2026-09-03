<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a like on a chirp comment.
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $chirp_comment_id
 * @property-read \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @property-read ChirpComment $chirpComment
 */
#[Fillable('user_id', 'chirp_comment_id')]
class ChirpCommentLike extends Model
{
    /** @use HasFactory<\Database\Factories\ChirpCommentLikeFactory> */
    use HasFactory;

    const UPDATED_AT = null;

    /**
     * Resolve the user who liked the comment.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Resolve the comment that was liked.
     *
     * @return BelongsTo<ChirpComment, $this>
     */
    public function chirpComment(): BelongsTo
    {
        return $this->belongsTo(ChirpComment::class);
    }
}
