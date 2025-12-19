<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Share the menu configuration with all views for dynamic sidebar rendering
        if (config()->has('menu')) {
            View::share('menu', config('menu'));
        } else {
            View::share('menu', []);
        }
    }
}
