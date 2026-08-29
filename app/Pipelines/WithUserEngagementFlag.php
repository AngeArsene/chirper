<?php

namespace App\Pipelines;

use App\Enums\EngagementType;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WithUserEngagementFlag
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
        $query->withExists([
            "{$this->engagement->relation()} as {$this->engagement->pastTense()}_by_current_user"
            => fn($query) => $query->whereBelongsTo(Auth::user()),
        ]);

        return $next($query);
    }
}
