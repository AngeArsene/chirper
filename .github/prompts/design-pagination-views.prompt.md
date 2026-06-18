---
agent: 'agent'
description: 'Fill the two empty custom pagination views (pagination.paginate and pagination.simple-paginate) with Tailwind CSS + DaisyUI markup that is visually consistent with the Chirper design'
---

## Role
You are a senior Laravel/Blade developer working on the Chirper project. You write clean, idiomatic Blade and produce Tailwind CSS + DaisyUI views that are visually consistent with the rest of the application.

## Context
The project uses:
- Laravel 13 / PHP 8.4
- Tailwind CSS v4 + DaisyUI
- Blade anonymous components
- Bootstrap pagination is **enabled** via `Paginator::useBootstrapFive()` or similar — confirm in `AppServiceProvider.php`
- Two custom pagination views already registered in `AppServiceProvider::boot()`:
  - `Paginator::defaultView('pagination.paginate')` → `resources/views/pagination/paginate.blade.php`
  - `Paginator::defaultSimpleView('pagination.simple-paginate')` → `resources/views/pagination/simple-paginate.blade.php`
- Both files currently contain only an empty `<div>` placeholder

## Task

Perform the following steps **in order**:

### Step 1 — Read the existing codebase

Before writing a single line, read and fully understand each of the following files:

1. `app/Providers/AppServiceProvider.php` — confirm whether Bootstrap is activated alongside the custom views, and note the exact view names registered.
2. `resources/views/layouts/main.blade.php` (or whichever file `App\View\Components\Layouts\Main` renders) — extract the full `<head>`, body background, font stack, and every DaisyUI/Tailwind class token used.
3. `resources/views/chirps/index.blade.php` — this is the view that renders `{{ $chirps->links() }}`; note the surrounding card/container classes, spacing scale, and color tokens so the pagination sits naturally inside it.
4. One or two other content views (e.g. `resources/views/auth/login.blade.php`, any chirp partial) — extract the exact button classes used for primary and secondary actions (color, size, shape, hover state).
5. `resources/css/app.css` — note any `@theme` tokens or custom CSS variables defined for Tailwind v4.
6. `resources/views/pagination/paginate.blade.php` and `resources/views/pagination/simple-paginate.blade.php` — confirm both are empty placeholders before writing anything.

> Use every available MCP server tool to read these files. Do not assume class names — extract them verbatim from the source.

### Step 2 — Fill `resources/views/pagination/paginate.blade.php`

Rules:
- This view receives the `$paginator` instance automatically from Laravel.
- Only render anything if `$paginator->hasPages()` returns `true` — wrap the entire markup in `@if ($paginator->hasPages())`.
- **Link window:** show at most **3 pages before and 3 pages after** the current page — use `$paginator->getUrlRange()` or iterate `$elements` and slice accordingly. Do not show all pages.
- **Structure:** a single centered row containing:
  - A clearly recognisable **« Previous** button on the left
  - The page number buttons in the middle
  - A clearly recognisable **Next »** button on the right
- **Previous / Next buttons** must be visually distinct from page number buttons — use the exact primary or accent button classes found in the existing views (not a generic `btn` alone). Disabled state (first/last page) must use the DaisyUI `btn-disabled` class and remove the `href`.
- **Current page** button must be visually highlighted — use the active/selected DaisyUI variant consistent with the project's color scheme.
- **Ellipsis** (`...`) must appear between the windowed range and the first/last page link when pages are skipped.
- Use only Tailwind utility classes and DaisyUI component classes already present in the project — do not invent new ones.
- Do not use inline styles.
- Do not hardcode colors — use only the CSS variable tokens or Tailwind color aliases already present in `app.css` or the existing views.
- The block must feel native to Chirper — as if it has always been part of the project.

### Step 3 — Fill `resources/views/pagination/simple-paginate.blade.php`

Rules:
- This view is used by `simplePaginate()` — it only has **Previous** and **Next**, no page numbers.
- Only render anything if `$paginator->hasPages()` returns `true`.
- **Structure:** a single centered row with:
  - A **« Previous** button on the left — disabled and styled with `btn-disabled` when `$paginator->onFirstPage()`
  - A **Next »** button on the right — disabled and styled with `btn-disabled` when `!$paginator->hasMorePages()`
- Reuse the exact same button classes determined in Step 1 for consistency with `paginate.blade.php`.
- Same no-inline-styles, no-hardcoded-colors rules as above.

### Step 4 — Verify

Run the following commands and report any errors or warnings:

```bash
php artisan view:clear
php artisan config:clear
php artisan route:list --name=chirps.index
```

Then confirm:
- `$chirps->links()` in `chirps/index.blade.php` now renders the custom `pagination.paginate` view.
- The link window is correctly limited to ±3 pages around the current page.
- Previous/Next buttons are visually distinct and clearly recognisable.
- Disabled states work correctly on the first and last pages.

## Output Quality Guidelines

- **Visual consistency is the primary goal.** Extract actual class names from existing views — do not invent new ones.
- **Do not use inline styles.**
- **Do not hardcode colors.** Use only tokens already defined in the project.
- **Match the existing code style exactly** — indentation, Blade directive formatting, quote style — as found in the files you read in Step 1.
- The two pagination views must look like they have always been part of Chirper, not generated by an external tool.
