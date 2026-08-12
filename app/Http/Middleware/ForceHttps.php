<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        // Force HTTPS for all requests
        if (!$request->secure() && env('APP_ENV') !== 'local') {
            URL::forceScheme('https');

            // Redirect to HTTPS if not already
            if (!$request->isSecure()) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        // Handle ngrok proxy
        if ($request->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
            $request->server->set('HTTPS', 'on');
        }

        return $next($request);
    }
}
