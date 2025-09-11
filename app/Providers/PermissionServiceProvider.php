<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class PermissionServiceProvider extends ServiceProvider
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
        // Blade directive for permission checking
        Blade::directive('hasPermission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission($permission)): ?>";
        });

        Blade::directive('endhasPermission', function () {
            return "<?php endif; ?>";
        });

        // Blade directive for role checking
        Blade::directive('hasRole', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->role && auth()->user()->role->name === $role): ?>";
        });

        Blade::directive('endhasRole', function () {
            return "<?php endif; ?>";
        });

        // Blade directive for super admin checking
        Blade::directive('isSuperAdmin', function () {
            return "<?php if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'super_admin'): ?>";
        });

        Blade::directive('endisSuperAdmin', function () {
            return "<?php endif; ?>";
        });
    }
}
