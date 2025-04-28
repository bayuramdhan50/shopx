<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Make sure that Filament only allows admin users to access the admin panel
        Panel::configureUsing(function (Panel $panel): void {
            $panel->authGuard('web')
                  ->requiresAuthentication()
                  ->registration(false);
        });
    }
}
