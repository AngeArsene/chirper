<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;
use Laravolt\Avatar\Facade as Avatar;

class ProfileCover extends Component
{
    public string $cover;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $user
    ) {
        $fallback = Avatar::create("")
            ->setDimension(1200, 400)
            ->setShape('square')
            ->toBase64();

        $this->cover = $this->user->cover ? Storage::url($this->user->cover) : $fallback;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'blade'
<figure class="h-40 w-full">
    <img src="{{ $cover }}" alt="{{ __($user->name . "'s cover image") }}" class="h-full w-full object-cover">
</figure>
blade;
    }
}
