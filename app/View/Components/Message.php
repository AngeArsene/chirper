<?php

namespace App\View\Components;

use App\Contracts\Messageable;
use App\Enums\MessageableType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Message extends Component
{
    public string $editRouteName;
    public string $deleteRouteName;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public Messageable $message,
        public string $baseRouteName,
        public ?Messageable $parent = null,
    ) {
        $this->editRouteName = match ($this->message->type()) {
            MessageableType::Chirp => route("{$this->baseRouteName}.edit", $this->message),
            MessageableType::Comment => route("{$this->baseRouteName}.edit", [$this->parent, $this->message]),
        };

        $this->deleteRouteName = match ($this->message->type()) {
            MessageableType::Chirp => route("{$this->baseRouteName}.destroy", $this->message),
            MessageableType::Comment => route("{$this->baseRouteName}.destroy", [$this->parent, $this->message]),
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message');
    }
}
