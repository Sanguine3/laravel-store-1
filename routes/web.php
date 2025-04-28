<?php

use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\OrderController;
use App\Livewire\Admin\Categories\CategoryForm;
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Orders\OrderDetail;
use App\Livewire\Admin\Orders\OrderList;
use App\Livewire\Admin\Products\ProductForm;
use App\Livewire\Admin\Products\ProductList;
use App\Livewire\Admin\Profile\Index as AdminProfileIndex;
use App\Livewire\Admin\Users\UserForm;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;


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
})->name('home');

// Changed to use Customer\ProductController@index
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Added route for showing a single product
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


Route::middleware(['auth', 'verified'])->group(function () {
    // Changed to use DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Changed to use OrderController
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    // Settings routes
    Route::middleware(['auth'])->group(function () {
        Route::redirect('settings', 'settings/profile');

        Route::get('settings/profile', Profile::class)->name('settings.profile');
        Route::get('settings/password', Password::class)->name('settings.password');
        Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    });


    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        // Changed to use Admin Dashboard Controller
        Route::get('/', AdminDashboard::class)->name('dashboard');

        // Admin Products
        Route::get('/products', ProductList::class)->name('products');

        Route::get('/products/create', ProductForm::class)->name('products.create');

        Route::get('/products/{id}/edit', ProductForm::class)->name('products.edit');

        // Admin Categories
        Route::get('/categories', CategoryList::class)->name('categories');

        Route::get('/categories/create', CategoryForm::class)->name('categories.create');

        Route::get('/categories/{id}/edit', CategoryForm::class)->name('categories.edit');

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
