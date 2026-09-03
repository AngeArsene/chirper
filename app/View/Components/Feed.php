<?php

namespace App\View\Components;

use App\Contracts\Messageable;
use App\Enums\MessageableType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Feed extends Component
{
    /**
     * @param  Collection<int, Messageable>|AbstractPaginator  $messages
     */
    public function __construct(
        public Collection|AbstractPaginator $messages,
        public string $baseRouteName,
        public string $emptyStateMessage,
        public ?Messageable $parent = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.feed');
    }
}
