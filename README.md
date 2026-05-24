# Chirper

> A modern, lightweight social application built with Laravel 13 and Tailwind CSS.

[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-13.8%2B-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## What is Chirper?

Chirper is a modern web application that demonstrates best practices in Laravel development. Built on Laravel 13 with a focus on developer experience, Chirper showcases how to build scalable, maintainable applications using Laravel's latest features including attributes-based model configuration, modern PHP 8.3 syntax, and optimized build tooling.

## Key Features

- **Modern Laravel 13 Architecture**: Built with the latest Laravel framework features and best practices
- **User Authentication**: Secure user registration and authentication system
- **Real-time UI with Tailwind CSS**: Beautiful, responsive interface powered by Tailwind CSS and DaisyUI
- **Optimized Development**: Vite-powered development server with hot module replacement
- **Comprehensive Testing**: PHPUnit test suite with both feature and unit tests
- **Database Migrations**: Schema-first database development with migrations
- **AI-Ready Development**: Supports AI coding agents with Laravel Boost for enhanced workflows

## Why Chirper?

Chirper is ideal for:

- **Learning Modern Laravel**: A clean starting point for understanding Laravel 13 patterns and conventions
- **Building Social Applications**: Foundation for building social features with Laravel
- **AI-Assisted Development**: Configured to work seamlessly with AI coding agents like Claude, Cursor, and GitHub Copilot
- **Production-Ready Foundation**: Follows Laravel best practices and includes security by default

## Quick Start

### Prerequisites

- PHP 8.3 or higher
- Composer
- Node.js 18+ and npm
- A supported database (SQLite, MySQL, PostgreSQL, etc.)

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd chirper
   ```

2. **Run the setup script**
   ```bash
   composer run setup
   ```
   
   This will:
   - Install PHP dependencies
   - Create `.env` file from `.env.example`
   - Generate application key
   - Run database migrations
   - Install and build frontend assets

3. **Start the development server**
   ```bash
   composer run dev
   ```
   
   This runs:
   - PHP development server (port 8000)
   - Queue listener
   - Vite development server

4. **Access the application**
   Open your browser and navigate to `http://localhost:8000`

### Manual Setup

If you prefer to set up manually:

```bash
# Install dependencies
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install --ignore-scripts
npm run build
```

Run the development server:
```bash
php artisan serve
```

In another terminal, run Vite:
```bash
npm run dev
```

## Development Workflow

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Run with coverage
php artisan test --coverage
```

### Code Quality

```bash
# Format code with Pint
./vendor/bin/pint

# Run Pint in check mode
./vendor/bin/pint --test
```

### Database Management

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset database
php artisan migrate:reset

# Seed database
php artisan db:seed
```

### Building for Production

```bash
npm run build
php artisan migrate --force
```

## Project Structure

```
chirper/
├── app/
│   ├── Models/              # Eloquent models
│   ├── Http/Controllers/    # Application controllers
│   └── Providers/           # Service providers
├── config/                  # Application configuration
├── database/
│   ├── migrations/          # Database migrations
│   ├── factories/           # Model factories
│   └── seeders/             # Database seeders
├── resources/
│   ├── js/                  # JavaScript assets
│   ├── css/                 # Stylesheets
│   └── views/               # Blade templates
├── routes/                  # Route definitions
├── tests/                   # Feature and unit tests
├── composer.json            # PHP dependencies
├── package.json             # Node.js dependencies
└── vite.config.js          # Vite configuration
```

## Technology Stack

- **Framework**: [Laravel 13](https://laravel.com/docs)
- **PHP**: 8.3+
- **CSS**: [Tailwind CSS 4](https://tailwindcss.com/)
- **UI Components**: [DaisyUI](https://daisyui.com/)
- **Build Tool**: [Vite](https://vitejs.dev/)
- **Package Manager**: Composer (PHP) & npm (Node.js)
- **Testing**: PHPUnit
- **Database**: Supports SQLite, MySQL, PostgreSQL, SQL Server

## Configuration

Key configuration files:

- `.env` - Application environment variables (created during setup)
- `config/app.php` - Application settings
- `config/database.php` - Database connection configuration
- `config/mail.php` - Mail driver settings
- `vite.config.js` - Frontend build configuration

See [Laravel Configuration Documentation](https://laravel.com/docs/configuration) for detailed configuration options.

## Getting Help

- **Laravel Documentation**: [laravel.com/docs](https://laravel.com/docs)
- **Laravel Discussion Forum**: [laracasts.com](https://laracasts.com)
- **GitHub Issues**: Open an issue for bug reports or feature requests
- **Laravel Bootcamp**: [laravel.com/bootcamp](https://laravel.com/bootcamp) for comprehensive learning

## Contributing

Contributions are welcome! Please review the [Laravel contribution guidelines](https://laravel.com/docs/contributions).

To contribute:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -am 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## AI-Assisted Development

Chirper is optimized for AI coding agents. To enhance your workflow with Laravel Boost:

```bash
composer require laravel/boost --dev
php artisan boost:install
```

This provides agents with 15+ tools and skills for building Laravel applications while maintaining best practices.

## Maintainers

This project is maintained by [AngeArsene](https://github.com/AngeArsene).

## License

Chirper is open-sourced software licensed under the [MIT license](LICENSE).

## Support the Project

If you find Chirper useful:

- ⭐ Star the repository
- 🐛 Report issues or suggest improvements
- 🤝 Contribute improvements or new features
- 📢 Share it with other developers

---

**Ready to get started?** Follow the [Quick Start](#quick-start) section above and start building with Chirper!
