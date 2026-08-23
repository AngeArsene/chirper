<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class WithEngagementCount
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private string $relation,
    ) {
        //
    }

    /**
     * Invoke the class instance.
     */
    public function __invoke(Builder $query, Closure $next): mixed
    {
        $query->withCount($this->relation);

        return $next($query);
    }
}
