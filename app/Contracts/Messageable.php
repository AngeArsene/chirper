<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Defines the shared relationship contract for models that contains messages written by users.
 */
interface Messageable
{
    /**
     * Resolve the user who authored the message.
     *
     * @return BelongsTo The owning user relationship for the message record.
     */
    public function user(): BelongsTo;
}
