<?php

namespace App\Providers;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Filament\Widgets\SalesOverviewWidget;

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
     */    public function boot(): void
    {
        // Configure Filament panels to use the web guard and require admin permission
        Panel::configureUsing(function (Panel $panel): void {
            $panel->authGuard('web')
                  ->requiresAuthentication()
                  ->registration(false);
                  
            // Skip login page if user is already authenticated via web guard
            if (auth()->check() && auth()->user()->is_admin) {
                $panel->tenant(auth()->user());
            }
        });
        
        // Register Livewire components for our custom widgets
        \Livewire\Livewire::component('filament.widgets.sales-overview-widget', \App\Filament\Widgets\SalesOverviewWidget::class);
    }
}
