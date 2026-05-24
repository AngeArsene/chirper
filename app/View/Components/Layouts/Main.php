<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

/**
 * Main Layout Component
 *
 * This component serves as the primary layout wrapper for the application.
 *
 * @package App\View\Components\Layouts
 * @category View Components
 *
 * @example
 * <x-layouts.main>
 *       <div class="max-w-2xl mx-auto">
 *          <div class="card bg-base-100 shadow mt-8">
 *              <div class="card-body">
 *                  <div>
 *                      <h1 class="text-3xl font-bold">Welcome to Chirper!</h1>
 *                      <p class="mt-4 text-base-content/60">This is your brand new Laravel application. Time to make it
 *                          sing (or chirp)!</p>
 *                  </div>
 *              </div>
 *          </div>
 *      </div>
 *  </x-layouts.main>
 */
class Main extends Component
{
    /**
     * Main layout component constructor.
     */
    public function __construct(
    ) {
    }

    /**
     * Generate the page title based on the current route name.
     *
     * Converts the current route name to a human-readable title by:
     * - Replacing dots and hyphens with spaces
     * - Replacing 'index' with 'home' (case-insensitive)
     * - Converting to title case
     *
     * @return string The formatted page title with app name appended
     */
    public function page_title(): string
    {
        $title = Str::of(Route::currentRouteName())->replace(['.', '-'], ' ')->replace('index', 'home', false)->title();

        return $title . ' - ' . config('app.name');
    }

    /**
     * Render the main layout component.
     *
     * This method is responsible for rendering the main layout view
     * that serves as the primary template structure for the application.
     *
     * @return View|Closure|string The rendered main layout view, a closure, or a string representation.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.main');
    }
}
