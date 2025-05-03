<?php

namespace App\Providers;

use App\Services\Security\PBKDF2Service;
use Illuminate\Support\ServiceProvider;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PBKDF2Service::class, function ($app) {
            $service = new PBKDF2Service();

            // Konfigurasi bisa diubah melalui config/security.php jika diperlukan
            // $service->setIterations(config('security.pbkdf2.iterations', 10000));

            return $service;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
