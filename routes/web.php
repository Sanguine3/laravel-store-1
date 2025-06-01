<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Settings\AppearanceController;
use App\Http\Controllers\Settings\DeleteUserController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::resource('products', ProductController::class)->only(['index', 'show']);

// Guest-only routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [LoginController::class, 'login'])->name('login');

    // Register
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    // Password reset links
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset password
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Email verification
    Route::get('verify-email', [VerifyEmailController::class, 'showNotice'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [VerifyEmailController::class, 'sendVerificationNotification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Confirm password
    Route::get('confirm-password', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmPasswordController::class, 'confirm'])->name('password.confirm.post');
});

// Authenticated and verified routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Customer dashboard
    Route::get('dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Customer orders
    Route::resource('orders', CustomerOrderController::class)->only(['index', 'show']);

    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::post('add/{product}', [CartController::class, 'add'])->name('add');
        Route::get('/', [CartController::class, 'index'])->name('view');
        Route::patch('update/{productId}', [CartController::class, 'update'])->name('update');
        Route::delete('remove/{productId}', [CartController::class, 'remove'])->name('remove');
    });

    // Checkout routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'show'])->name('show');
        Route::post('/', [CheckoutController::class, 'process'])->name('process');
    });

    // Settings routes
    Route::redirect('settings', 'settings/profile');
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('password', [PasswordController::class, 'edit'])->name('password');
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::get('appearance', [AppearanceController::class, 'edit'])->name('appearance');
        Route::delete('delete-account', [DeleteUserController::class, 'destroy'])->name('delete-account');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'edit', 'update']);
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::put('users/{user}/restore', [AdminUserController::class, 'restore'])
            ->withTrashed()
            ->name('users.restore');
    });
});
