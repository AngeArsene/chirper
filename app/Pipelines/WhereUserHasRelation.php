<?php

namespace App\Pipelines;

use App\Enums\EngagementType;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WhereUserHasRelation
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
        $query->whereHas($this->engagement->relation(), function ($query) {
            $query->whereBelongsTo(Auth::user());
        });

        return $next($query);
    }
}
