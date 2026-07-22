<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\Component;

/**
 * Main Layout Component
 *
 * This component serves as the primary layout wrapper for the application.
 */
class Main extends Component
{
    /**
     * Main layout component constructor.
     */
    public function __construct() {}

    /**
     * Generate the page title based on the current route name.
     *
     * @return string The formatted page title with app name appended
     */
    public function page_title(): string
    {
        $title = Str::of(Route::currentRouteName())
            ->replace(['.', '-'], ' ')
            ->replace('index', 'home', false)
            ->title();

        return $title.' - '.config('app.name');
    }

    /**
     * Render the main layout component.
     *
     * @return View|Closure|string The rendered main layout view.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.main');
    }
}
