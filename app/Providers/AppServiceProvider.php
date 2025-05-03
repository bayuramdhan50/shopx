<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Js;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register PBKDF2 service as a singleton
        $this->app->singleton(\App\Services\Security\PBKDF2Service::class, function ($app) {
            return new \App\Services\Security\PBKDF2Service();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register admin logout script for Filament
        FilamentAsset::register([
            Js::make('admin-logout', __DIR__ . '/../../resources/js/admin-logout.js'),
        ]);
    }
}
