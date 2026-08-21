<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $chirp_id
 * @property-read Carbon|null $created_at
 */
#[Fillable(['user_id', 'chirp_id'])]
class ChirpLike extends Model
{
    const UPDATED_AT = null;

    /**
     * Get the user that owns the chirp like.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the chirp that owns the chirp like.
     *
     * @return BelongsTo<Chirp>
     */
    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }
}
