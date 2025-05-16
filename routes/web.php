<?php

use App\Http\Controllers\Customer\ProductActions\IndexController as CustomerProductIndexController;
use App\Http\Controllers\Customer\ProductActions\ShowController as CustomerProductShowController;
use App\Http\Controllers\Admin\DashboardActions\IndexController as AdminDashboardIndexController;
use App\Http\Controllers\Admin\ProductActions\IndexController as ProductIndexController;
use App\Http\Controllers\Admin\ProductActions\CreateController as ProductCreateController;
use App\Http\Controllers\Admin\ProductActions\StoreController as ProductStoreController;
use App\Http\Controllers\Admin\ProductActions\EditController as ProductEditController;
use App\Http\Controllers\Admin\ProductActions\UpdateController as ProductUpdateController;
use App\Http\Controllers\Admin\ProductActions\DestroyController as ProductDestroyController;
use App\Http\Controllers\Admin\CategoryActions\IndexController as CategoryIndexController;
use App\Http\Controllers\Admin\CategoryActions\CreateController as CategoryCreateController;
use App\Http\Controllers\Admin\CategoryActions\StoreController as CategoryStoreController;
use App\Http\Controllers\Admin\CategoryActions\EditController as CategoryEditController;
use App\Http\Controllers\Admin\CategoryActions\UpdateController as CategoryUpdateController;
use App\Http\Controllers\Admin\CategoryActions\DestroyController as CategoryDestroyController;
use App\Http\Controllers\Admin\OrderActions\IndexController as AdminOrderIndexController;
use App\Http\Controllers\Admin\OrderActions\ShowController as AdminOrderShowController;
use App\Http\Controllers\Admin\OrderActions\UpdateStatusController as AdminOrderUpdateStatusController;
use App\Http\Controllers\Admin\UserActions\IndexController as UserIndexController;
use App\Http\Controllers\Admin\UserActions\CreateController as UserCreateController;
use App\Http\Controllers\Admin\UserActions\StoreController as UserStoreController;
use App\Http\Controllers\Admin\UserActions\EditController as UserEditController;
use App\Http\Controllers\Admin\UserActions\UpdateController as UserUpdateController;
use App\Http\Controllers\Admin\UserActions\DestroyController as UserDestroyController;
use App\Http\Controllers\Admin\UserActions\RestoreController as UserRestoreController;
use App\Http\Controllers\Customer\DashboardActions\IndexController as CustomerDashboardIndexController;
use App\Http\Controllers\Customer\OrderActions\IndexController as CustomerOrderIndexController;
use App\Http\Controllers\Customer\OrderActions\ShowController as CustomerOrderShowController;

// Added
use App\Http\Controllers\Customer\CartActions\AddController as CartAddController;
use App\Http\Controllers\Customer\CartActions\ViewController as CartViewController;
use App\Http\Controllers\Customer\CartActions\UpdateController as CartUpdateController;
use App\Http\Controllers\Customer\CartActions\RemoveController as CartRemoveController;
use App\Http\Controllers\Customer\CheckoutActions\ShowFormController as CheckoutShowFormController;
use App\Http\Controllers\Customer\CheckoutActions\ProcessController as CheckoutProcessController;
use App\Http\Controllers\Settings\ProfileActions\EditController as ProfileEditController;
use App\Http\Controllers\Settings\ProfileActions\UpdateController as ProfileUpdateController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\AppearanceController;
use App\Http\Controllers\Settings\DeleteUserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

//Product routes
Route::get('/products', CustomerProductIndexController::class)->name('products.index');
Route::get('/products/{product}', CustomerProductShowController::class)->name('products.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', CustomerDashboardIndexController::class)
        ->name('dashboard');

    // Order routes
    Route::get('/orders', CustomerOrderIndexController::class)->name('orders');
    Route::get('/orders/{order}', CustomerOrderShowController::class)->name('orders.show');

    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::post('/add/{product}', CartAddController::class)->name('add');
        Route::get('/', CartViewController::class)->name('view');
        Route::patch('/update/{productId}', CartUpdateController::class)->name('update');
        Route::delete('/remove/{productId}', CartRemoveController::class)->name('remove');
    });

    // Checkout routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', CheckoutShowFormController::class)->name('show');
        Route::post('/', CheckoutProcessController::class)->name('process');
    });

    // Settings routes
    Route::middleware(['auth'])->group(function () {
        Route::redirect('settings', 'settings/profile');

        Route::get('settings/profile', ProfileEditController::class)->name('settings.profile');
        Route::patch('settings/profile', ProfileUpdateController::class)->name('settings.profile.update');

        Route::get('settings/password', [PasswordController::class, 'edit'])->name('settings.password');
        Route::put('settings/password', [PasswordController::class, 'update'])->name('settings.password.update');

        Route::get('settings/appearance', [AppearanceController::class, 'edit'])->name('settings.appearance');
        Route::delete('settings/delete-account', [DeleteUserController::class, 'destroy'])->name('settings.delete-account');
    });


    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::get('/', AdminDashboardIndexController::class)->name('dashboard');

        // Admin Products
        Route::get('/products', ProductIndexController::class)->name('products.index');
        Route::get('/products/create', ProductCreateController::class)->name('products.create');
        Route::post('/products', ProductStoreController::class)->name('products.store');
        Route::get('/products/{product}/edit', ProductEditController::class)->name('products.edit');
        Route::put('/products/{product}', ProductUpdateController::class)->name('products.update');
        Route::delete('/products/{product}', ProductDestroyController::class)->name('products.destroy');

        // Admin Categories
        Route::get('/categories', CategoryIndexController::class)->name('categories.index');
        Route::get('/categories/create', CategoryCreateController::class)->name('categories.create');
        Route::post('/categories', CategoryStoreController::class)->name('categories.store');
        Route::get('/categories/{category}/edit', CategoryEditController::class)->name('categories.edit');
        Route::put('/categories/{category}', CategoryUpdateController::class)->name('categories.update');
        Route::delete('/categories/{category}', CategoryDestroyController::class)->name('categories.destroy');

        // Admin Orders
        Route::get('/orders', AdminOrderIndexController::class)->name('orders.index');
        Route::get('/orders/{order}', AdminOrderShowController::class)->name('orders.show');
        Route::put('/orders/{order}/status', AdminOrderUpdateStatusController::class)->name('orders.updateStatus');

        // Admin Users
        Route::get('/users', UserIndexController::class)->name('users.index');
        Route::get('/users/create', UserCreateController::class)->name('users.create');
        Route::post('/users', UserStoreController::class)->name('users.store');
        Route::get('/users/{user}/edit', UserEditController::class)->name('users.edit');
        Route::put('/users/{user}', UserUpdateController::class)->name('users.update');
        Route::delete('/users/{user}', UserDestroyController::class)->name('users.destroy');
        Route::put('/users/{user}/restore', UserRestoreController::class)->name('users.restore');
    });
});

require __DIR__ . '/auth.php'; // Auth routes
