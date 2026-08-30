<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Represents a user's saved chirp.
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $chirp_id
 * @property-read Carbon|null $created_at
 * @property-read User $user
 * @property-read Chirp $chirp
 */
#[Fillable(['user_id', 'chirp_id'])]
class ChirpBookmark extends Model
{
    /** @use HasFactory<\Database\Factories\ChirpBookmarkFactory> */
    use HasFactory;

    const UPDATED_AT = null;

    /**
     * Get the user who saved the chirp.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the chirp saved by the user.
     *
     * @return BelongsTo<Chirp>
     */
    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }
}
