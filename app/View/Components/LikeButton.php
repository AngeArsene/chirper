<?php

namespace App\View\Components;

use App\Models\Chirp;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LikeButton extends Component
{
    public bool $isLiked;

    public string $method;

    public string $textColor;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public Chirp $chirp,
    ) {
        $this->isLiked = $chirp->liked_by_current_user;
        $this->method = $this->isLiked ? 'DELETE' : 'POST';
        $this->textColor = $this->isLiked ? 'text-error' : 'text-base-content/60 hover:text-error';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.like-button');
    }
}
