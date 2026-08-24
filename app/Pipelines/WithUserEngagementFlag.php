<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WithUserEngagementFlag
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private string $relation,
        private string $pastTenseVerb,
    ) {
        //
    }

    /**
     * Invoke the class instance.
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $query->withExists([
            "{$this->relation} as {$this->pastTenseVerb}_by_current_user" => fn ($query) => $query->where('user_id', Auth::id()),
        ]);

        return $next($query);
    }
}
