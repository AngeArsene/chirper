<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WithUserEngagementFlag extends EngagementPipeline
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(Builder $query, Closure $next): Builder
    {
        $exists = array_reduce($this->engagements, function ($carry, $engagement) {
            $carry["{$engagement->relation()} as {$engagement->pastTense()}_by_current_user"] =
                fn ($query) => $query->whereBelongsTo(Auth::user());

            return $carry;
        }, []);

        $query->withExists($exists);

        return $next($query);
    }
}
