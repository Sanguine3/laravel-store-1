# Laravel E-Commerce Practice App

Welcome to our Laravel e-commerce application, built with Laravel, Inertia.js, and Vue 3.

## Getting Started

Let's get your development environment up and running. First, make sure you have PHP 8.4+, Node.js 18+, and your
preferred database (MySQL/PostgreSQL/SQLite) installed.

### Quick Start

Clone the repository and install the necessary dependencies:

```bash
git clone https://github.com/yourusername/your-repo.git
cd your-repo
composer install
npm install
```

Set up your environment:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in the `.env` file, then run:

```bash
php artisan migrate --seed
npm run dev
php artisan serve
```

You should now have the application running at `http://localhost:8000`.

## Project Overview

This platform offers a complete e-commerce solution with distinct experiences for customers and administrators. The
frontend is built with Vue 3 and Inertia.js, providing a smooth single-page application feel while maintaining
traditional server-side routing benefits.

### Key Components

**For Customers:**
Browse products, add items to cart, and complete purchases through a streamlined checkout process. Your order history
and account settings are easily accessible from your profile.

**For Administrators:**
Manage products, categories, and user accounts through an intuitive dashboard. Track orders and monitor sales with
built-in analytics.

## Development Workflow

When working on the project, you'll primarily use these commands:

- `npm run dev` - Start the Vite development server with hot module replacement
- `npm run build` - Optimize assets for production
- `php artisan serve` - Run the Laravel development server
- `php artisan test` - Run the test suite

## Project Structure

The codebase follows a clean organization pattern:

- `resources/js/Components` - Reusable Vue components
- `resources/js/Pages` - Page components organized by feature
- `app/Http/Controllers` - Laravel controllers handling backend logic
- `database/migrations` - Database schema definitions

## Configuration

Most configuration happens in the `.env` file. Key settings to review:

- Database connection details
- Mail configuration (for password resets and notifications)
- Cache and session drivers
- Application URL and environment settings

## Contributing

We welcome contributions! Here's how to get started:

1. Fork the repository and create a feature branch
2. Make your changes with clear, concise commit messages
3. Submit a pull request with a description of your changes

## Built With

- [Laravel](https://laravel.com/) - The PHP framework for web artisans
- [Vue 3](https://vuejs.org/) - The Progressive JavaScript Framework
- [Inertia.js](https://inertiajs.com/) - The modern monolith
- [PrimeVue](https://primevue.org/) - UI Component Library

## License

This project is open-source software licensed under the MIT license. Feel free to use it for personal or commercial
projects.

---

Thanks for checking out the project! If you have any questions or run into issues, don't hesitate to open an issue in
the repository.
