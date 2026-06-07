---
agent: 'agent'
description: 'Create a custom error layout component and branded error views (401, 402, 403, 404, 419, 429, 500, 503) that match the existing Chirper visual design'
---

## Role
You are a senior Laravel/Blade developer working on the Chirper project. You write clean, idiomatic Laravel 13 code and produce Tailwind CSS + DaisyUI views that are visually consistent with the rest of the application.

## Context
The project uses:
- Laravel 13 / PHP 8.4
- Tailwind CSS v4 + DaisyUI
- Blade anonymous components and class-based layout components
- An existing layout component at `app/View/Components/Layouts/Main.php` that returns a view via its `render()` method
- The corresponding blade layout file lives in `resources/views/layouts/`
- Error views are expected at `resources/views/errors/{code}.blade.php`

## Task

Perform the following steps **in order**:

### Step 1 — Read the existing codebase
Before writing any file, read and fully understand each of the following:

1. `app/View/Components/Layouts/Main.php` — study the class structure, constructor signature, public properties, and what view string the `render()` method returns.
2. The blade file that `Main.php` renders (e.g. `resources/views/layouts/main.blade.php`) — note the HTML structure, `<head>` contents (Vite directives, meta tags, font imports), the navigation markup, `{{ $slot }}` placement, Tailwind/DaisyUI classes used, and any shared partials or sub-components included.
3. Any existing error views under `resources/views/errors/` — note what (if anything) is already there.
4. One or two representative content views (e.g. `resources/views/chirps/index.blade.php`, `resources/views/auth/login.blade.php`) — extract the exact color palette tokens, spacing scale, button styles, card styles, and typography scale used across the project so the error pages feel native.
5. `resources/css/app.css` — note any custom CSS variables or `@theme` tokens defined for Tailwind v4.

### Step 2 — Create the Errors layout component class

Create `app/View/Components/Layouts/Error.php`.

Rules:
- Mirror the structure of `Main.php` as closely as possible (same namespace, same `extends Component`, same import list pattern).
- The class **must not** require any constructor arguments that are unavailable at error-render time (keep it argument-free or accept only optional props like `string $title = 'Error'`).
- The `render()` method must return `view('layouts.error')`.
- Add a `public string $title` property (default `'Chirper'`) so the blade layout can display a contextual page title.

```php
<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class Errors extends Component
{
    /**
     * Error layout component constructor.
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

        return $title . ' - ' . config('app.name');
    }

    /**
     * Render the main layout component.
     *
     * @return View|Closure|string The rendered main layout view.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.error');
    }
}
```

### Step 3 — Create the Errors layout blade file

Create `resources/views/layouts/error.blade.php`.

Rules:
- Copy the `<head>` section **verbatim** from the main layout (same Vite directives, same meta charset/viewport, same font import if present, same favicon if present).
- Use `{{ $page_title() }}` for the `<title>` tag.
- Do **not** include the authenticated navigation bar — error pages are shown to any visitor regardless of auth state.
- Keep the same `<body>` background color and font stack as the main layout.
- Render `{{ $slot }}` centered on the page — use the same flex/grid centering pattern found in the project's auth layouts (login, register) if they use a centered card pattern.
- Include the same footer markup (if any) as the main layout, or a minimal version consistent with it.
- The overall look must be unmistakably "Chirper" — same background, same font, same DaisyUI theme variables.

### Step 4 — Create the individual error views

Create the following four files. Each must:
- Use `<x-layouts.error />` as its wrapping component (matching Laravel's anonymous component tag convention for `App\View\Components\Layouts\Error`).
- Display the HTTP status code in a large, visually prominent way using Tailwind classes consistent with the project's typographic scale.
- Display a short, friendly, human-readable message.
- Include a single clear CTA button — "Go back home" — linking to `route('chirps.index')`, styled with the same primary button classes used elsewhere in the project (inspect existing buttons in content views to get the exact classes).
- Be concise — no walls of text.

#### `resources/views/errors/401.blade.php`
- Title: `401 — Unauthorized`
- Heading: `401`
- Message: `You need to be logged in to access this page.`
- CTA: "Sign in" linking to `route('login')` instead of "Go back home"

#### `resources/views/errors/402.blade.php`
- Title: `402 — Payment Required`
- Heading: `402`
- Message: `Access to this page requires an active subscription.`

#### `resources/views/errors/403.blade.php`
- Title: `403 — Forbidden`
- Heading: `403`
- Message: `You don't have permission to access this page.`

#### `resources/views/errors/404.blade.php`
- Title: `404 — Not Found`
- Heading: `404`
- Message: `The page you're looking for doesn't exist or has been moved.`

#### `resources/views/errors/419.blade.php`
- Title: `419 — Page Expired`
- Heading: `419`
- Message: `Your session has expired. Please refresh the page and try again.`
- CTA: "Refresh" using `onclick="window.location.reload()"` instead of a route link

#### `resources/views/errors/429.blade.php`
- Title: `429 — Too Many Requests`
- Heading: `429`
- Message: `You've made too many requests in a short period. Please wait a moment and try again.`

#### `resources/views/errors/500.blade.php`
- Title: `500 — Server Error`
- Heading: `500`
- Message: `Something went wrong on our end. We're working on it.`

#### `resources/views/errors/503.blade.php`
- Title: `503 — Under Maintenance`
- Heading: `503`
- Message: `Chirper is temporarily down for maintenance. Please check back shortly.`

### Step 5 — Verify component auto-discovery

Confirm that Laravel will auto-discover `App\View\Components\Layouts\Error` and map it to the tag `<x-layouts.error />` without any manual registration. If the project has a custom component namespace registered in `AppServiceProvider`, add the `Error` class to the same namespace. No changes to `config/app.php` or service providers should be needed for standard auto-discovery.

### Step 6 — Run a quick sanity check

Run the following commands and report any errors:

```bash
php artisan view:clear
php artisan config:clear
php artisan route:list --name=chirps.index
```

If `chirps.index` does not exist, use the correct home/index route name found in `routes/web.php` for the CTA button.

## Output Quality Guidelines

- **Visual consistency is the primary goal.** Extract actual class names from existing views — do not invent new ones.
- **Do not use inline styles.** Use only Tailwind utility classes and DaisyUI component classes.
- **Do not hardcode colors.** Use only the CSS variable tokens or Tailwind color aliases already present in the project.
- **Match the existing code style exactly** — indentation, quote style, blade directive formatting — as found in the files you read in Step 1.
- The 8 error views should look like they have always been part of Chirper, not like they were generated by a different tool.
