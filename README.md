# Chirper

> A Laravel 13 microblogging demo that lets users sign up, log in, publish short updates, and manage their profile.

[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-13.8%2B-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)

## What the project does

Chirper is a small, practical social app built with Laravel and Blade. It demonstrates how to combine authentication, authorization, validation, and a polished frontend in one working example.

## Why the project is useful

This project is a good starting point for learning or building on top of a modern Laravel stack. It covers:

- user registration and login flows
- authenticated posting, editing, and deleting of chirps
- policy-based authorization so users only manage their own content
- profile updates and account removal
- Tailwind CSS styling with Vite asset compilation

## Key features

- Secure sign-in and sign-up pages
- Create, update, and delete chirp posts
- Latest chirps feed with user relationships loaded efficiently
- Profile editing and account deletion
- Request validation for auth and post actions
- Testable Laravel structure with PHPUnit

## Getting started

### Prerequisites

Make sure you have:

- PHP 8.3 or newer
- Composer
- Node.js 18+ and npm
- A supported database (the default setup uses SQLite)

### Quick setup

```bash
git clone https://github.com/AngeArsene/chirper.git
cd chirper
composer run setup
```

The setup script:

- installs Composer dependencies
- copies `.env.example` to `.env`
- generates an application key
- runs migrations
- installs frontend dependencies
- builds the Vite assets

### Run the app

```bash
composer run dev
```

This starts the Laravel server, queue worker, and Vite dev server so you can open the app in your browser at `http://localhost:8000`.

### Manual setup (if needed)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
npm run dev
```

## Example workflow

Once the app is running:

1. Visit `/register` to create an account.
2. Sign in and post your first chirp from the home page.
3. Edit or delete your own post from the interface.
4. Open `/profile` to update your details.

## Project structure

```text
app/            # Controllers, models, policies, requests, and middleware
bootstrap/      # Framework bootstrap files
config/         # Application configuration
database/       # Migrations, factories, and seeders
public/         # Web entry point
resources/      # Blade views, CSS, and JavaScript assets
routes/         # Route definitions
tests/          # Feature and unit tests
```

## Testing

Run the full test suite:

```bash
php artisan test
```

You can also run a specific test file when working on one area of the app.

## Support and documentation

Useful references:

- [Laravel documentation](https://laravel.com/docs)
- [Vite documentation](https://vitejs.dev/guide/)
- [Tailwind CSS documentation](https://tailwindcss.com/docs)
- Issues and discussions for this repository

## Contributing

Contributions are welcome. If you want to help:

1. Fork the repository
2. Create a feature branch
3. Make your changes and test them
4. Open a pull request with a clear summary

If you are unsure where to start, opening an issue first is a good way to discuss an idea or bug report.

## Maintainers

This project is maintained by the repository owner and contributors.
