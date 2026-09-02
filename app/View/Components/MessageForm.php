<?php

namespace App\View\Components;

use App\Contracts\Messageable;
use App\Enums\MessageableType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MessageForm extends Component
{
    public string $actionRoute;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public MessageableType $for,
        public string $baseRouteName,
        public ?Messageable $parent = null,
    ) {
        $this->actionRoute = match ($for) {
            MessageableType::Chirp => route("{$baseRouteName}.store"),
            MessageableType::Comment => route("{$baseRouteName}.store", $this->parent),
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message-form');
    }
}
