# MyApp

A Laravel web application using Blade, Alpine.js, and Grid.js for a streamlined front-end experience.

## ✨ Features

- Laravel 12.x
- Blade Components for reusable UI
- Alpine.js for lightweight interactivity
- Grid.js for dynamic tables (search, sort, pagination)
- Tailwind CSS for styling
- Blade Icons (Heroicons, Phosphor, Tabler)
- Vanilla JS fetch helpers for AJAX

## 📦 Tech Stack

- **Backend**: PHP 8.4+, Laravel 12
- **Frontend**: Blade + Alpine.js + Grid.js
- **Styling**: Tailwind CSS
- **Build Tool**: Vite
- **Testing**: PHPUnit
- **CI**: GitHub Actions

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.4
- Composer
- Node.js >= 18
- Git
- SQLite (default) or MySQL/PostgreSQL

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/<your-username>/my-app.git
   cd my-app
   ```
2. Install PHP dependencies:
   ```bash
   composer install --no-interaction --prefer-dist
   ```
3. Install Node.js dependencies:
   ```bash
   npm ci
   ```
4. Copy and configure environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. Run database migrations:
   ```bash
   php artisan migrate
   ```

## 🛠 Development

Run the local development server and asset watcher:

```bash
npm run dev
php artisan serve --host=127.0.0.1 --port=8000
```

Visit http://127.0.0.1:8000

## 🧪 Testing

Run the PHP test suite with PHPUnit:

```bash
php artisan test
```

## 🎨 Building for Production

Compile and minify assets for production:

```bash
npm run build
```

## 🔄 Continuous Integration

A minimal GitHub Actions workflow (`.github/workflows/ci.yml`) runs on push/PR to `main`:

- Installs PHP & Node.js dependencies
- Runs migrations & PHPUnit tests
- Builds frontend assets

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add new feature'`)
4. Push to origin (`git push origin feature/YourFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details. 