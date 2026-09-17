<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;
use Laravolt\Avatar\Facade as Avatar;

class ProfileAvatar extends Component
{
    public string $avatar;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $user,
    ) {
        $this->avatar = $this->user->avatar
            ? Storage::url($this->user->avatar)
            : Avatar::create($this->user->name)->toBase64();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'blade'
<div class="size-16 rounded-full">
    <img src="{{ $avatar }}" alt="{{ $user->name }}'s avatar" class="rounded-full" />
</div>
blade;
    }
}
