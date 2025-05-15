<?php

use Illuminate\Support\Facades\Route;
// Controller Imports for Auth Routes
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [LoginController::class, 'login'])->name('login');

    // Registration Routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    // Password Reset Link Routes
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Password Reset Routes
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Email Verification Routes
    Route::get('verify-email', [VerifyEmailController::class, 'showNotice'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class) // Uses __invoke
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [VerifyEmailController::class, 'sendVerificationNotification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Password Confirmation Routes
    Route::get('confirm-password', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmPasswordController::class, 'confirm'])->name('password.confirm.post');
});

// Logout Route
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
