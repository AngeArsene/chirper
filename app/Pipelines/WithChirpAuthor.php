<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class WithChirpAuthor
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(Builder $query, Closure $next): mixed
    {
        $query->with('user:id,name,email');

        return $next($query);
    }
}
