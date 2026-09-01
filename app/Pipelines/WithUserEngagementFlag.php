<?php

namespace App\Pipelines;

use App\Enums\EngagementType;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class WithUserEngagementFlag
{
    private array $engagements;

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
