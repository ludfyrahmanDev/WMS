<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if (env(key: 'APP_ENV') !=='local') {
            // URL::forceScheme(scheme:'https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom Blade directive for checking company access
        Blade::if('companyAccess', function () {
            return auth()->check() && auth()->user()->hasCompanyAccess();
        });

        // Custom Blade directive for checking CV access
        Blade::if('canAccessCV', function ($cvId) {
            return auth()->check() && auth()->user()->canAccessCV($cvId);
        });

        // Custom Blade directive for checking if user has access to all CVs
        Blade::if('hasAllCVAccess', function () {
            return auth()->check() && auth()->user()->getCompanyAccessLevel() === 'all';
        });
    }
}
