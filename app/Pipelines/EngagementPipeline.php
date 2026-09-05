<?php

namespace App\Pipelines;

use App\Enums\EngagementType;
use InvalidArgumentException;

abstract class EngagementPipeline
{
    protected array $engagements;

    /**
     * Create a new class instance.
     */
    public function __construct(EngagementType ...$engagements)
    {
        if (empty($engagements)) {
            throw new InvalidArgumentException(
                'At least one EngagementType must be provided to '.static::class.'.'
            );
        }

        $this->engagements = $engagements;
    }
}
