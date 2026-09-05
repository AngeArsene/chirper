<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class WithEngagementCount extends EngagementPipeline
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $query->withCount(array_map(fn ($engagement) => $engagement->relation(), $this->engagements));

        return $next($query);
    }
}
