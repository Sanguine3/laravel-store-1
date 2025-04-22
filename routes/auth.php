<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\{
    Login,
    Register,
    ForgotPassword,
    ResetPassword,
    ConfirmPassword,
    VerifyEmail
};

/*
|--------------------------------------------------------------------------
| Authentication (Livewire) Routes
|--------------------------------------------------------------------------
| All authentication screens are served as Livewire page components with
| route names matching Laravel convention. Use guest for public, auth
| for protected, and ensure all point to App\Livewire\Auth classes.
*/

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', VerifyEmail::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::get('confirm-password', ConfirmPassword::class)->name('password.confirm');
});

Route::post('logout', App\Livewire\Auth\Logout::class)
    ->name('logout');
