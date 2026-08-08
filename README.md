# Chirper

A Laravel 13 microblogging application built around Blade views, Tailwind CSS v4 assets, and SQLite-backed persistence. The application currently implements the familiar web flow for a simple social feed: registration, sign-in, creating and managing chirps, profile edits, and account removal.

## What the app does

This repository is a small Laravel web application. Authenticated users can publish short messages to a paginated home feed, edit or delete their own chirps, and update their profile details. The middleware and policy layer protect the authenticated-only pages and authorize ownership-sensitive actions.

## Features

- Web routes are mounted from the framework bootstrap layer and grouped into authentication and profile flows.
- The home page is a paginated chirp feed served by `ChirpController@index` and authorized through `ChirpPolicy@viewAll`.
- Authenticated POST, PUT/PATCH, and DELETE chirp actions are defined as a resource route with `auth.only` authorization middleware and throttling settings for store/update/delete.
- Registration, login, and logout are handled through `AuthController` and the `auth` route file.
- Profile editing, password confirmation, and account removal are routed through `UserProfileController` and the `profile` route file.
- Middleware aliases expose `guest.only` and `auth.only` custom guard behavior through `EnsureUserIsGuest` and `EnsureUserIsAuthenticated`.
- The schema includes a users table, sessions table, password reset tokens, and a `chirps` table with a nullable unique `idempotency_key` column added in a later migration.

## Project structure

```text
app/
├── Enums/ # AppRouteNameToAction enum for route-action labels
├── Exceptions/ # RouteNotNamedException and ViewResolutionException
├── Http/
│   ├── Controllers/ # AuthController, ChirpController, UserProfileController
│   └── Middleware/ # EnsureUserIsGuest, EnsureUserIsAuthenticated
├── Models/ # User and Chirp Eloquent models
└── Policies/ # ChirpPolicy authorization rules
bootstrap/
└── app.php # route registration, middleware aliases, exception wiring
database/
├── migrations/ # users, password reset, sessions, and chirps schema
└── seeders/ # DatabaseSeeder for the seeded default user and sample data
routes/
├── web.php # home feed and authenticated chirp resource routes
├── auth.php # sign-in/sign-up/logout endpoints
└── profile.php # profile view/edit/delete endpoints
.env.example # default SQLite-like config and seeded account env keys
composer.json
package.json
```

## Setup

### Quick start

```bash
composer run setup
```

The `setup` Composer script installs dependencies, creates `.env` from `.env.example` when missing, generates the app key, runs migrations, installs frontend dependencies with `npm install --ignore-scripts`, and builds assets with `npm run build`.

After the setup script completes, configure the seeded default user before running the seed step:

```bash
DEFAULT_USER_NAME="Example User Name"
DEFAULT_USER_EMAIL="some-valide@email.test"
DEFAULT_USER_PASSWORD="some-secure-password"
```

Those keys are consumed by the seeder in [database/seeders/DatabaseSeeder.php](database/seeders/DatabaseSeeder.php) and are exposed through [config/app.php](config/app.php) as the default user credentials for local development. The seeded default-user password must satisfy the runtime password policy defined in [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php): `Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()`.

```bash
php artisan db:seed
composer run dev
```

`composer run dev` starts the Laravel server, queue worker, and Vite dev server together.

### Manual steps

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan migrate
```

Before seeding, set the required seeded default-user values in `.env`:

```bash
DEFAULT_USER_NAME="Example User Name"
DEFAULT_USER_EMAIL="some-valide@email.test"
DEFAULT_USER_PASSWORD="some-secure-password"
```

The chosen `DEFAULT_USER_PASSWORD` must satisfy the same validation policy as the registration and login validation rules, namely `Password::default()` with the default password rules set in [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php): minimum 8 characters, mixed case, letters, numbers, symbols, and uncompromised password checks.

```bash
php artisan db:seed
php artisan serve
```

## Usage

```bash
php artisan serve
php artisan test
vendor/bin/pint --dirty --format agent
```

This repository currently has PHPUnit-based tests under [tests/Feature/ChirpTest.php](tests/Feature/ChirpTest.php) and related feature coverage. The package manifest does not declare Pest as a development dependency, so `pest` is not a currently supported command in this app layout.

## Status

_Last synced with commit cde3b08c86fe6923c62007cb88aa1e956770d2c5 (2026-08-08)_
