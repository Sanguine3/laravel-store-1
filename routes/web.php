<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| General application pages go here.
| Auth routes are imported from routes/auth.php.
*/

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Product routes
    Route::get('/products', function () {
        return view('products');
    })->name('products');

    Route::get('/products/{productId}', function ($productId) {
        return view('product-details', ['productId' => $productId]);
    })->name('product.details');

    // Settings routes
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Admin Products
        Route::get('/products', function () {
            return view('admin.products.index');
        })->name('products');

        Route::get('/products/create', function () {
            return view('admin.products.form');
        })->name('products.create');

        Route::get('/products/{id}/edit', function ($id) {
            return view('admin.products.form', ['product' => null]);
        })->name('products.edit');

        // Admin Categories
        Route::get('/categories', function () {
            return view('admin.categories.index');
        })->name('categories');

        Route::get('/categories/create', function () {
            return view('admin.categories.form');
        })->name('categories.create');

        Route::get('/categories/{id}/edit', function ($id) {
            return view('admin.categories.form', ['category' => null]);
        })->name('categories.edit');

        // Admin Orders
        Route::get('/orders', function () {
            return view('admin.orders.index');
        })->name('orders');

        Route::get('/orders/{id}', function ($id) {
            return view('admin.orders.show', ['order' => null]);
        })->name('orders.show');

        // Admin Users
        Route::get('/users', function () {
            return view('admin.users.index');
        })->name('users');

        Route::get('/users/create', function () {
            return view('admin.users.form');
        })->name('users.create');

        Route::get('/users/{id}/edit', function ($id) {
            return view('admin.users.form', ['user' => null]);
        })->name('users.edit');

        // Admin Profile
        Route::get('/profile', function () {
            return view('admin.profile.index');
        })->name('profile');

        // Placeholder routes for form submissions
        Route::put('/profile/update', function () {
            return redirect()->back()->with('success', 'Profile updated successfully');
        })->name('profile.update');

        Route::put('/password/update', function () {
            return redirect()->back()->with('success', 'Password updated successfully');
        })->name('password.update');
    });
});

// Auth Livewire screens (login, register, etc.)
require __DIR__.'/auth.php';
