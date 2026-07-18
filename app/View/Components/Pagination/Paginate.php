<?php

namespace App\View\Components\Pagination;

use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Paginate extends Component
{
    public int $current;
    public int $last;
    public int $start;
    public int $end;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public LengthAwarePaginator $paginator,
        int $window = 2
    ) {
        $this->current = $paginator->currentPage();
        $this->last    = $paginator->lastPage();
        $this->start   = max(1, $this->current - $window);
        $this->end     = min($this->last, $this->current + $window);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('pagination.paginate');
    }
}
