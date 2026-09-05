<?php

namespace App\Contracts;

use App\Enums\MessageableType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Defines the shared relationship contract for models that contains messages written by users.
 */
interface Messageable
{
    /**
     * Get the type of messageable entity.
     *
     * @return MessageableType The type of messageable entity.
     */
    public function type(): MessageableType;

    /**
     * Resolve the user who authored the message.
     *
     * @return BelongsTo The owning user relationship for the message record.
     */
    public function user(): BelongsTo;
}
