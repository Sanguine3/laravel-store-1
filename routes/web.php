<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Admin Components
use App\Livewire\Admin\Dashboard as AdminDashboard; // Alias Admin Dashboard
use App\Livewire\Admin\Users\UserList;
use App\Livewire\Admin\Users\UserForm;
use App\Livewire\Admin\Orders\OrderList;
use App\Livewire\Admin\Orders\OrderDetail;
use App\Livewire\Admin\Products\ProductList;
use App\Livewire\Admin\Products\ProductForm;
use App\Livewire\Admin\Profile\Index as AdminProfileIndex;

// Customer Facing Components
use App\Livewire\Dashboard as CustomerDashboard; // Alias Customer Dashboard
use App\Livewire\Products\ProductIndex; // Import new component

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| General application pages go here.
| Auth routes are imported from routes/auth.php.
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Use alias for Customer Dashboard
    Route::get('/dashboard', CustomerDashboard::class)
        ->name('dashboard');

    // Customer facing products page
    Route::get('/products', ProductIndex::class)->name('products.index');

    // Remove the dedicated product detail route as details are shown in a modal
    // Route::get('/products/{productId}', function ($productId) {
    //     return view('product-details', ['productId' => $productId]);
    // })->name('product.details');

    // Settings routes
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'users.profile')->name('settings.profile');
    Volt::route('settings/password', 'users.password')->name('settings.password');
    Volt::route('settings/appearance', 'users.appearance')->name('settings.appearance');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        // Use alias for Admin Dashboard
        Route::get('/', AdminDashboard::class)->name('dashboard');

        // Admin Products
        Route::get('/products', ProductList::class)->name('products');

        Route::get('/products/create', ProductForm::class)->name('products.create');

        Route::get('/products/{id}/edit', ProductForm::class)->name('products.edit');

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
        Route::get('/orders', OrderList::class)->name('orders');

        Route::get('/orders/{id}', OrderDetail::class)->name('orders.show');

        // Admin Users
        Route::get('/users', UserList::class)->name('users');

        Route::get('/users/create', UserForm::class)->name('users.create');

        Route::get('/users/{id}/edit', UserForm::class)->name('users.edit');

        // Admin Profile
        Route::get('/profile', AdminProfileIndex::class)->name('profile');
    });
});

// Auth Livewire screens (login, register, etc.)
require __DIR__.'/auth.php';
