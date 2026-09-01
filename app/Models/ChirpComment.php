<?php

namespace App\Models;

use App\Contracts\Messageable;
use Database\Factories\ChirpCommentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'chirp_id', 'message', 'idempotency_key'])]
class ChirpComment extends Model implements Messageable
{
    /** @use HasFactory<ChirpCommentFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }
}
