<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Error extends Component
{
    /**
     * The page title for the error layout.
     */
    public string $title;

    /**
     * Error layout component constructor.
     */
    public function __construct(string $title = 'Chirper')
    {
        $this->title = $title;
    }

    /**
     * Generate the page title for the error layout.
     */
    public function page_title(): string
    {
        return $this->title.' - '.config('app.name');
    }

    /**
     * Render the error layout component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.error');
    }
}
