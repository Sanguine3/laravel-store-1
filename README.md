# LaraStore

A modern web application built with Laravel and Livewire, featuring a responsive design and powerful UI components.

## ✨ Features

- 🚀 Laravel 10.x
- ⚡ Livewire for dynamic interfaces
- 🎨 Blade components for UI
- 📊 Integrated with Flux for state management
- 🔍 Search functionality
- 📱 Responsive design
- 🛠 Developer-friendly with Laravel's ecosystem

## 🛠 Tech Stack

- **Backend**: PHP 8.4+, Laravel 10.x
- **Frontend**: Livewire, Alpine.js
- **Styling**: Tailwind CSS
- **Icons**: Blade Icons (Heroicons, Phosphor, Tabler)
- **Database**: MySQL/PostgreSQL/SQLite
- **Development Tools**: Laravel Sail, Laravel Tinker

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/larastore.git
   cd larastore
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   - Configure your `.env` file with database credentials
   - Run migrations and seeders:
     ```bash
     php artisan migrate --seed
     ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```
   
   For frontend assets:
   ```bash
   npm run dev
   ```

## 🔧 Configuration

- Edit `.env` for environment-specific settings
- Configure mail settings in `.env` for email functionality
- Set up your preferred cache and queue drivers

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

## 🔗 Links

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://laravel-livewire.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)

---

Built with ❤️ using Laravel & Livewire
