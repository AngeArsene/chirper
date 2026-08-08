---
agent: 'agent'
description: 'Update README.md to reflect the current state of the Chirper Laravel project'
---

## Role

Senior Laravel engineer maintaining documentation for open source projects.

## Task

Update (or create, if missing) `README.md` for **Chirper** — a Laravel 13 / PHP 8.4 microblogging app (Blade, Tailwind v4, DaisyUI, SQLite).

### 1. Scope the review efficiently
Don't crawl the whole repo. Check only:
- `bootstrap/app.php` — route file registration, middleware aliases, exception wiring
- `routes/web.php`, `routes/auth.php`, `routes/profile.php` — endpoints, route names, throttle/middleware config per route
- `app/Models/`, `app/Http/Controllers/`, `app/Policies/` — domain logic (Chirps, auth, profile) — note actual class/method names, not generic descriptions
- `app/Http/Middleware/` — custom guards (`EnsureUserIsGuest`, `EnsureUserIsAuthenticated`)
- `app/Exceptions/` — custom exception classes and what they handle
- `app/Enums/` — domain-specific enums, by actual name and purpose
- `database/migrations/` — schema shape, including any later-added columns (e.g. nullable/unique additions)
- `database/seeders/` — default-user seeding logic, by actual seeder class name
- `config/` — any config file exposing env values referenced in `.env.example` (e.g. default-user credentials)
- `composer.json` (`scripts` for `setup`/`dev`, and what each script actually runs step by step), `package.json`
- `.env.example` — required config, including `DEFAULT_USER_NAME`, `DEFAULT_USER_EMAIL`, `DEFAULT_USER_PASSWORD`
- Wherever the default user's password is validated (seeder, FormRequest, or `Password::defaults()`/`Password::default()` in a service provider) — state the actual rule found, never assume Laravel's stock default
- `tests/` — actual test framework in use (Pest or PHPUnit — check `composer.json` require-dev and file syntax, don't assume either) and actual file paths
- Existing `README.md`, if present

### 2. Check commit history
Run `git log --oneline -20` (or since the README's last relevant change). Identify:
- The most recent commit hash/date
- Whether meaningful features shipped since the README was last updated (compare against a "Last updated" marker or the README's own content/claims)

### 3. Update README.md
Preserve accurate existing content; rewrite only what's stale or missing. Sections:
- **Title & tagline** — project name plus a one-line description of what it's built with (stack) and does
- **What the app does** — a short paragraph: who uses it, the core flow (e.g. register → post → manage feed)
- **Features** — specific, technical bullets grounded in step 1: real controller/method names, real middleware alias names, real throttle/authorization config, real schema details (e.g. a nullable unique column added later). Never generic ("has authentication") when the specific mechanism is known.
- **Project structure** — a fenced tree covering only files/folders actually found in step 1, each comment naming the *actual* classes/files inside (e.g. `# AppRouteNameToAction enum for route-action labels`, not `# domain-specific enums`). Omit folders that don't exist; add any sibling files discovered that clearly matter.
- **Setup** — two paths, both ending in a seeded default user:
  - **Quick start**, in order:
    1. `composer run setup` (only if this script exists — verify in `composer.json`; briefly state what it actually does, e.g. installs deps, copies `.env`, generates key, migrates, builds assets)
    2. Set `DEFAULT_USER_NAME`, `DEFAULT_USER_EMAIL`, `DEFAULT_USER_PASSWORD` in `.env` — required before seeding, since these become the seeded default user's login credentials. State the actual password validation rule found in step 1, with a relative link to the file it's defined in.
    3. `php artisan db:seed` (skip this line only if `setup` already runs seeding internally — say so explicitly instead)
    4. `composer run dev` (verify it exists; briefly state what it starts, e.g. server + queue + Vite)
  - **Manual steps**, in order:
    1. `composer install`
    2. `cp .env.example .env`
    3. `php artisan key:generate`
    4. `npm install`
    5. `npm run build` (or `npm run dev`)
    6. `php artisan migrate`
    7. **Before seeding** — set `DEFAULT_USER_NAME`, `DEFAULT_USER_EMAIL`, `DEFAULT_USER_PASSWORD` in `.env`, same credentials/password-rule note as above (relative link to the validation source)
    8. `php artisan db:seed`
    9. `php artisan serve`
- **Usage** — actual commands only: dev server, whichever test runner is actually configured (Pest or PHPUnit — never assume Pest by default), and the lint/format command as it actually appears in `composer.json`/`vendor/bin`. If a commonly-expected tool (e.g. Pest) isn't actually present, say so in one line rather than listing it.
- **Status footer** — `_Last synced with commit <hash> (<date>)_` so future runs (and users) can see at a glance if the README is behind

## Guidelines

- Be terse. No filler, no marketing language.
- GitHub Flavored Markdown, relative links only — link directly to source files when citing a specific rule or class (e.g. password policy, seeder).
- No API docs, no license text, no full CONTRIBUTING content — link out instead.
- Never fabricate command names, class names, file paths, or validation rules — verify against actual source before writing them into the README.
- If nothing changed since the last sync commit, say so and skip rewriting sections unnecessarily.
