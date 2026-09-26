<?php

namespace App\View\Components\Layouts;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Profile extends Component
{
    /**
     * Create a profile layout component.
     *
     * @param User $user
     * @param bool|null $editProfileImages
     */
    public function __construct(
        public User $user,
        public ?bool $editProfileImages = false
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.profile');
    }
}
