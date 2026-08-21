# Chirper

A Laravel 13 microblogging application built around Blade views, Tailwind CSS v4 assets, and SQLite-backed persistence. The application currently implements the familiar web flow for a simple social feed: registration, sign-in, creating and managing chirps, profile edits, and account removal.

## What the app does

This repository is a small Laravel web application. Authenticated users can publish short messages to a paginated home feed, edit or delete their own chirps, and update their profile details. The middleware and policy layer protect the authenticated-only pages and authorize ownership-sensitive actions. Users can also like or unlike chirps, and the home feed ranks posts by how much engagement they receive.

## Features

- Web routes are mounted from the framework bootstrap layer and grouped into authentication and profile flows.
- The home page is a paginated chirp feed served by `ChirpController@index` and authorized through `ChirpPolicy@viewAll`.
- Authenticated POST, PUT/PATCH, and DELETE chirp actions are defined as a resource route with `auth.only` authorization middleware and throttling settings for store/update/delete.
- Registration, login, and logout are handled through `AuthController` and the `auth` route file.
- Profile editing and account removal are routed through `UserProfileController` and the `profile` route file.
- [app/Http/Controllers/PasswordController.php](app/Http/Controllers/PasswordController.php) updates the user's password and checks the current password during confirmation. You can find its routes in [bootstrap/app.php](bootstrap/app.php).
- Middleware aliases expose `guest.only` and `auth.only` custom guard behavior through `EnsureUserIsGuest` and `EnsureUserIsAuthenticated`.
- The schema includes a users table, sessions table, password reset tokens, and a `chirps` table with a nullable unique `idempotency_key` column added in a later migration.
- `ChirpController@index` now loads `likes_count` and `liked_by_current_user` metadata.
- Authenticated users can like and unlike a chirp through `ChirpLikeController` and the `chirps.like` route, using `POST` and `DELETE` requests with `auth.only` and `throttle:16,1`.
- The schema adds the `chirp_likes` table with `user_id`, `chirp_id`, and `created_at`, plus a unique pair constraint to prevent duplicate likes; `ChirpLikeSeeder` and `UserSeeder` populate sample engagement data for local development.

## Project structure

```text
app/
├── Enums/ # AppRouteNameToAction enum for route-action labels
├── Exceptions/ # RouteNotNamedException and ViewResolutionException
├── Http/
│   ├── Controllers/ # AuthController, ChirpController, ChirpLikeController, PasswordController, UserProfileController
│   └── Middleware/ # EnsureUserIsGuest, EnsureUserIsAuthenticated
├── Models/ # User, Chirp, and ChirpLike Eloquent models
├── Policies/ # ChirpPolicy authorization rules
└── View/
    └── Components/ # LikeButton component
bootstrap/
└── app.php # route registration, middleware aliases, password-confirm route wiring
database/
├── migrations/ # users, password reset, sessions, chirps, and chirp_likes schema
├── seeders/ # DatabaseSeeder, UserSeeder, and ChirpLikeSeeder local data setup
└── factories/ # UserFactory, ChirpFactory, and ChirpLikeFactory
resources/
└── views/
    └── components/ # like-button and engagement UI partials
routes/
├── web.php # home feed, authenticated chirp resource routes, and chirp like/unlike endpoints
├── auth.php # sign-in/sign-up/logout endpoints
└── profile.php # profile view/edit/delete and password-update endpoints
.env.example # SQLite default settings plus DEFAULT_USER_* keys
composer.json
package.json
```

## Setup

### Quick start

```bash
git clone https://github.com/AngeArsene/chirper.git && cd chirper
composer run setup
```

The `setup` Composer script installs dependencies, creates `.env` from `.env.example` when missing, generates the app key, runs migrations, installs frontend dependencies with `npm install --ignore-scripts`, and builds assets with `npm run build`.

After the setup script completes, and before running the database migrations and seeders, set the required seeded default-user values in `.env`:

```bash
DEFAULT_USER_NAME="Example User Name"
DEFAULT_USER_EMAIL="some-valide@email.test"
DEFAULT_USER_PASSWORD="some-secure-password"
```

Those keys are consumed by the seeder in [database/seeders/DatabaseSeeder.php](database/seeders/DatabaseSeeder.php) and are exposed through [config/app.php](config/app.php) as the default user credentials for local development. The seeded default-user password must satisfy the runtime password policy defined in [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php): `Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()`.

Now run migrations and seed the database:

```bash
php artisan migrate --seed
```

Finally run `composer run dev` to starts the Laravel server, queue worker, and Vite dev server together.

```bash
composer run dev
```

### Manual steps

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan migrate
```

This repository currently has PHPUnit-based tests under [tests/Feature/ChirpTest.php](tests/Feature/ChirpTest.php) and related feature coverage. The package manifest does not declare Pest as a development dependency, so `pest` is not a currently supported command in this app layout.

## Status

_Last synced with commit fa2f03b35974be1f7474b178d3bf02364feb0267 (2026-08-21)_
