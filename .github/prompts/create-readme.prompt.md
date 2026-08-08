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
- `bootstrap/app.php` — current routes files and endpoints structure
- `routes/web.php`, `routes/auth.php`, `routes/profile.php` — current features/endpoints
- `app/Models/`, `app/Http/Controllers/`, `app/Policies/` — domain logic (Chirps, auth, profile)
- `app/Http/Middleware/` — custom guards (`EnsureUserIsGuest`, `EnsureUserIsAuthenticated`)
- `app/Exceptions/` — error handling
- `app/Enums/` — domain-specific enums (if any)
- `database/migrations/`, `database/seeders/` — schema shape and default-user seeding logic
- `composer.json` (check `scripts` for `setup`/`dev` composer commands), `package.json`
- `.env.example` — required config, including `DEFAULT_USER_NAME`, `DEFAULT_USER_EMAIL`, `DEFAULT_USER_PASSWORD`
- Wherever the default user's password is validated (seeder, FormRequest, or `Password::defaults()` in a service provider) — to state the actual rule, not an assumed one
- `tests/` — testing approach (Pest/PHPUnit)
- Existing `README.md`, if present

### 2. Check commit history
Run `git log --oneline -20` (or since the README's last relevant change). Identify:
- The most recent commit hash/date
- Whether meaningful features shipped since the README was last updated (compare against a "Last updated" marker or the README's own content/claims)

### 3. Update README.md
Preserve accurate existing content; rewrite only what's stale or missing. Sections:
- **Title & description** — what Chirper does
- **Features** — derived from routes/controllers, not guessed
- **Project structure** — a fenced tree covering only the files/folders reviewed in step 1, each with a one-line purpose comment, e.g.:

app/
├── Enums/ # domain-specific enums
├── Exceptions/ # custom error handling
├── Http/
│ ├── Controllers/ # Chirps, auth, profile logic
│ └── Middleware/ # EnsureUserIsGuest, EnsureUserIsAuthenticated
├── Models/ # Eloquent models
└── Policies/ # authorization policies
bootstrap/
└── app.php # route file registration, middleware config
database/
├── migrations/ # schema
└── seeders/ # default-user seeding logic
routes/
├── web.php
├── auth.php
└── profile.php
.env.example # required config (see Setup)
composer.json
package.json

  Adjust entries/comments to what's actually found — don't list files that don't exist, and add any sibling files discovered in step 1 that clearly matter (e.g. an extra route file, a seeder class name).
- **Setup** — two paths, both ending in a seeded default user:
  - **Quick start**, in order: 
    1. `composer run setup`
    2. Set `DEFAULT_USER_NAME`, `DEFAULT_USER_EMAIL`, `DEFAULT_USER_PASSWORD` in `.env` — required before seeding, since these become the seeded default user's login credentials. State the actual password validation rule found in step 1 (don't invent one).
    3. `php artisan db:seed` (only if these scripts exist in `composer.json` — verify, don't assume; note whether `setup` already runs the seed internally)
    4. `composer run dev` (only if these scripts exist in `composer.json` — verify, don't assume; note whether `setup` already runs the dev script internally)
  - **Manual steps**, in order:
    1. `composer install`
    2. `cp .env.example .env`
    3. `php artisan key:generate`
    4. `npm install`
    5. `npm run build` (or `npm run dev`)
    6. `php artisan migrate`
    7. **Before seeding** — set `DEFAULT_USER_NAME`, `DEFAULT_USER_EMAIL`, `DEFAULT_USER_PASSWORD` in `.env`. These become the seeded default user's login credentials, so call this out as a required pre-step, not a side note. State the actual password validation rule found in step 1 (don't invent one) and note the chosen password must satisfy it.
    8. `php artisan db:seed`
    9. `php artisan serve`
- **Usage** — key commands (`php artisan serve`, `pest`, `pint`)
- **Status footer** — e.g. `_Last synced with commit <hash> (<date>)_` so future runs (and users) can see at a glance if the README is behind

## Guidelines

- Be terse. No filler, no marketing language.
- GitHub Flavored Markdown, relative links only.
- No API docs, no license text, no full CONTRIBUTING content — link out instead.
- Never fabricate command names or validation rules — verify against `composer.json`/source before writing them into the README.
- If nothing changed since the last sync commit, say so and skip rewriting sections unnecessarily.
