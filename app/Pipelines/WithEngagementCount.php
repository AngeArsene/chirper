<?php

namespace App\Pipelines;

use App\Enums\EngagementType;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

class WithEngagementCount
{
    private array $engagements;

    public function __construct(EngagementType ...$engagements)
    {
        if (empty($engagements)) {
            throw new InvalidArgumentException(
                'At least one EngagementType must be provided to '.static::class.'.'
            );
        }

        $this->engagements = $engagements;
    }

    /**
     * Invoke the class instance.
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $query->withCount(array_map(fn ($engagement) => $engagement->relation(), $this->engagements));

        return $next($query);
    }
}
