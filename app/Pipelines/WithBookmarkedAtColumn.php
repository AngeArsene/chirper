<?php

namespace App\Pipelines;

use App\Models\ChirpBookmark;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WithBookmarkedAtColumn
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Invoke the class instance.
     */
    public function __invoke(Builder $query, Closure $next): mixed
    {
        $query->addSelect([
            'bookmarked_at' => ChirpBookmark::select('created_at')
                ->whereColumn('chirp_id', 'chirps.id')
                ->where('user_id', Auth::id())
                ->latest()
                ->limit(1),
        ]);

        return $next($query);
    }
}
