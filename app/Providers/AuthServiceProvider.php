<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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

        // Grant all permissions to Super Admins

        Gate::before(function ($employee, $ability) {
            return $employee->hasRole('Super Admin') ? true : null;
        });
    }
}
