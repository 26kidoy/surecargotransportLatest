<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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
        // Register admin middleware alias
        Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);

        // Share CSP nonce with all views
        View::share('csp_nonce', app('csp.nonce'));

        // Force HTTPS for all generated URLs
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // Handle ngrok proxy - force HTTPS when behind ngrok
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' ||
            request()->server('HTTP_X_FORWARDED_SSL') === 'on') {
            URL::forceScheme('https');
        }
    }
}
