<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Manually Registered Service Providers
    |--------------------------------------------------------------------------
    |
    | This list is appended to the default list Laravel discovers at boot.
    | Filament providers have been removed to avoid autoload errors.
    |
    */

    App\Providers\AppServiceProvider::class,
    // App\Providers\Filament\AdminPanelProvider::class, // Removed
    // App\Providers\Filament\Sanguin3PanelProvider::class, // Removed
    App\Providers\VoltServiceProvider::class,
];
