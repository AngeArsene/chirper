<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read string $message
 * @property-read string|null $idempotency_key
 * @property-read \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\User $user
 */
#[Fillable(['message', 'idempotency_key'])]
class Chirp extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
