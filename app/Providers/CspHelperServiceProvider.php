<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Csp\CspServiceProvider;

class CspHelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(CspServiceProvider::class);

        $this->app->singleton('csp.nonce', function ($app) {
            return base64_encode(random_bytes(16));
        });
    }

    public function boot()
    {
        $helperPath = app_path('Helpers/csp_helper.php');
        if (file_exists($helperPath)) {
            require_once $helperPath;
        }
    }
}
