<?php

namespace App\View\Components;

use App\Contracts\Messageable;
use App\Enums\MessageableType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LikeButton extends Component
{
    /**
     * @var Messageable|array<Messageable>
     */
    public Messageable|array $actionArgs;

    public bool $isLiked;

    public string $method;

    public string $textColor;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public Messageable $message,
        public string $baseRouteName,
        public ?Messageable $parent = null,
    ) {
        $this->isLiked = $this->message->liked_by_current_user ?? false;
        $this->method = $this->isLiked ? 'DELETE' : 'POST';
        $this->textColor = $this->isLiked ? 'text-error' : 'text-base-content/60 hover:text-error';

        $this->actionArgs = match ($this->message->type()) {
            MessageableType::Chirp => $this->message,
            MessageableType::Comment => [$this->parent, $this->message],
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.like-button');
    }
}
