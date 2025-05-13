<?php

use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\AppearanceController;
use App\Http\Controllers\Settings\DeleteUserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders');

    // Settings routes
    Route::middleware(['auth'])->group(function () {
        Route::redirect('settings', 'settings/profile');

        Route::get('settings/profile', [ProfileController::class, 'edit'])->name('settings.profile');
        Route::patch('settings/profile', [ProfileController::class, 'update'])->name('settings.profile.update');

        Route::get('settings/password', [PasswordController::class, 'edit'])->name('settings.password');
        Route::put('settings/password', [PasswordController::class, 'update'])->name('settings.password.update');

        Route::get('settings/appearance', [AppearanceController::class, 'edit'])->name('settings.appearance');
        Route::delete('settings/delete-account', [DeleteUserController::class, 'destroy'])->name('settings.delete-account');
    });


    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin Products
        Route::resource('/products', ProductController::class);

        // Admin Categories
        Route::resource('/categories', CategoryController::class);

        // Admin Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Admin Users
        Route::resource('/users', UserController::class);
        Route::put('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    });
});

require __DIR__.'/auth.php'; // Auth routes
