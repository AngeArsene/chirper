<?php

namespace App\View\Components;

use App\Contracts\Messageable;
use App\Models\Chirp;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookmarkButton extends Component
{
    public bool $isBookmarked;

    public string $method;

    public string $textColor;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public Messageable $message,
    ) {
        $this->isBookmarked = $this->message->bookmarked_by_current_user;
        $this->method = $this->isBookmarked ? 'DELETE' : 'POST';
        $this->textColor = $this->isBookmarked ? 'text-primary' : 'text-base-content/60 hover:text-primary';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bookmark-button');
    }
}
