<?php

namespace App\View\Components;

use App\Contracts\Messageable;
use App\Enums\MessageableType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Message extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Messageable $message,
        public MessageableType $for,
        public string $baseRouteName,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message');
    }
}
