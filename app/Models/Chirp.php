<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $message
 * @property-read string|null $idempotency_key
 * @property-read Carbon|null $created_at
 * @property-read Carbon|null $updated_at
 * @property-read User $user
 */
#[Fillable(['message', 'idempotency_key'])]
class Chirp extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
