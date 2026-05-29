<?php

namespace App\Http\Controllers;

use App\Exceptions\RouteNotNamedException;
use App\Exceptions\ViewResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\View as IlluminateView;

/**
 * Base controller class for all application controllers.
 */
abstract class Controller
{
    /**
     * Resolve and render a view based on the current route name.
     *
     * @param  array  $params  Associative array of data to pass to the view.
     *
     * @return \Illuminate\View\View  Rendered view object with data bound to template.
     *
     * @throws \App\Exceptions\RouteNotNamedException  If the current route has no name.
     * @throws \App\Exceptions\ViewResolutionException  If no matching view exists and no fallback is available.
     *
     */
    protected function resolve_view(array $params = []): IlluminateView
    {
        $current_route_name = Route::currentRouteName();

        if (!$current_route_name) {
            throw new RouteNotNamedException('The current route " '. Route::current()->uri() .' " has no name.');
        }

        $view_name = '';
        $fallback_route_name = Str::replaceLast('.home', '.index', $current_route_name);

        if (View::exists($current_route_name)) {
            $view_name = $current_route_name;
        } elseif ($current_route_name === 'home' && View::exists('index')) {
            $view_name = 'index';
        } elseif (Str::endsWith($current_route_name, '.home') && View::exists($fallback_route_name)) {
            $view_name = $fallback_route_name;
        } else {
            throw new ViewResolutionException("View for route '{$current_route_name}' not found.");
        }

        return view($view_name, $params);
    }
}
