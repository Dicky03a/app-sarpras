<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the role middleware
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        Route::aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);
    }
}
