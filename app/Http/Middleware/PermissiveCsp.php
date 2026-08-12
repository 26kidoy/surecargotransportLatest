<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissiveCsp
{
    public function handle(Request $request, Closure $next)
    {
        // Generate a fresh nonce per request
        $nonce = base64_encode(random_bytes(16));

        // Share the nonce with all views
        view()->share('csp_nonce', $nonce);

        $response = $next($request);

        // Strict policy – includes all necessary CDNs for fonts, icons, and scripts
        $csp = [
            "default-src 'self'",
            
            // Script sources
            "script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com https://stackpath.bootstrapcdn.com https://unpkg.com https://*.googleapis.com https://*.googletagmanager.com 'nonce-$nonce' 'unsafe-inline'",
            
            // Style sources
            "style-src 'self' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://stackpath.bootstrapcdn.com https://use.fontawesome.com 'nonce-$nonce' 'unsafe-inline'",
            
            // Image sources
            "img-src 'self' data: https: blob: *.googleapis.com *.gstatic.com",
            
            // Font sources - includes Font Awesome CDN
            "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com https://use.fontawesome.com https://ka-f.fontawesome.com https://fonts.googleapis.com data:",
            
            // Connection sources
            "connect-src 'self' ws: wss: http: https: *.googleapis.com",
            
            "frame-src 'self'",
            "form-action 'self'",
            "base-uri 'self'",
            "object-src 'none'",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));

        return $response;
    }
}