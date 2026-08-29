<?php

namespace App\Pipelines;

use App\Enums\EngagementType;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class WithEngagementCount
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private EngagementType $engagement,
    ) {
        //
    }

    /**
     * Invoke the class instance.
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $query->withCount($this->engagement->relation());

        return $next($query);
    }
}
