<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Error extends Component
{
    /**
     * The page title for the error layout.
     *
     * @var string
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
     *
     * @return string
     */
    public function page_title(): string
    {
        return $this->title . ' - ' . config('app.name');
    }

    /**
     * Render the error layout component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('layouts.error');
    }
}
