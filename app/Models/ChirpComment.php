<?php

namespace App\Models;

use App\Concerns\IsLikeable;
use App\Contracts\Messageable;
use App\Enums\MessageableType;
use Database\Factories\ChirpCommentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Represents a comment added to a chirp.
 *
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $chirp_id
 * @property-read string $message
 * @property-read string|null $idempotency_key
 * @property-read Carbon|null $created_at
 * @property-read Carbon|null $updated_at
 * @property-read User $user
 * @property-read Chirp $chirp
 */
#[Fillable(['user_id', 'chirp_id', 'message', 'idempotency_key'])]
class ChirpComment extends Model implements Messageable
{
    /** @use HasFactory<ChirpCommentFactory> */
    use HasFactory, IsLikeable;

    /**
     * Get the type of messageable entity.
     *
     * @return MessageableType The type of messageable entity.
     */
    public function messageableType(): MessageableType
    {
        return MessageableType::Comment;
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
}
