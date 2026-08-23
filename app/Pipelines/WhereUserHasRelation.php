<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WhereUserHasRelation
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
        $query->whereHas($this->relation, function ($query) {
            $query->where('user_id', Auth::id());
        });

        return $next($query);
    }
}
