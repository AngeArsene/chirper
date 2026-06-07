# Chirper

> A Laravel 13 social microblogging demo with Tailwind CSS, Vite, and secure user workflows.

[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-13.8%2B-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## What the project does

Chirper is a lightweight social application built with Laravel 13. It demonstrates modern Laravel conventions through a small, real-world app where users can register, authenticate, and manage short "chirp" messages.

## Why the project is useful

Chirper is useful for developers who want a clean example of:

- Laravel 13 app structure with controllers, policies, and request validation
- User authentication and session management
- CRUD operations for an authenticated resource
- Tailwind CSS 4 styling with DaisyUI components
- Vite-powered frontend asset building
- A queue-ready Laravel development workflow

## Key features

- User registration, login, and logout
- Create, edit, and delete chirps
- Authorization rules that ensure users can only update or delete their own chirps
- Latest chirps feed with eager-loaded user data
- Database migrations with schema-first development
- Frontend build pipeline using Vite and Tailwind
- PHPUnit testing support

## Getting started

### Prerequisites

- PHP 8.3 or higher
- Composer
- Node.js 18+ and npm
- A supported database (SQLite, MySQL, PostgreSQL, SQL Server)

### Installation

```bash
git clone https://github.com/AngeArsene/chirper.git
cd chirper
composer run setup
```

The `composer run setup` task installs dependencies, copies `.env.example` to `.env`, generates the application key, runs migrations, and builds frontend assets.

### Start development

```bash
composer run dev
```

This command starts:

- the PHP development server
- a queue listener
- the Vite development server

Then open `http://localhost:8000` in your browser.

### Manual setup

If you want to run steps manually:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install --ignore-scripts
npm run build
php artisan serve
npm run dev
```

## Useful commands

```bash
composer run dev
composer run setup
php artisan test
npm run build
```

## Project structure

```text
chirper/
├── app/              # Application code, controllers, models, policies, and requests
├── config/           # Laravel configuration files
├── database/         # Migrations, factories, and seeders
├── public/           # Public entry point and assets
├── resources/        # Blade views, CSS, and JavaScript
├── routes/           # Route definitions
├── tests/            # Feature and unit tests
├── composer.json     # PHP dependencies and scripts
├── package.json      # Node dependencies and build scripts
└── vite.config.js    # Vite configuration
```

## Technology stack

- Laravel 13
- PHP 8.3+
- Tailwind CSS 4
- DaisyUI (via CDN)
- Vite
- Composer and npm
- PHPUnit

## Testing

Run the full suite:

```bash
php artisan test
```

Run a specific test file:

```bash
php artisan test tests/Feature/ExampleTest.php
```

## Support

- Laravel docs: https://laravel.com/docs
- GitHub Issues: open an issue in this repository for bugs, questions, or feature requests

## Contributing

Contributions are welcome.

1. Fork the repository
2. Create a branch (`git checkout -b feature/my-feature`)
3. Commit your changes
4. Push your branch
5. Open a pull request

For contribution guidance, follow Laravel's community conventions.

## Maintainer

Maintained by [AngeArsene](https://github.com/AngeArsene)

## License

Licensed under the [MIT license](LICENSE).
