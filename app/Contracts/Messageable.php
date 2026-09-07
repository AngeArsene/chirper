<?php

namespace App\Contracts;

use App\Enums\MessageableType;

/**
 * Defines the shared relationship contract for models that contains messages written by users.
 */
interface Messageable extends Likeable
{
    /**
     * Get the type of messageable entity.
     *
     * @return MessageableType The type of messageable entity.
     */
    public function messageableType(): MessageableType;
}
