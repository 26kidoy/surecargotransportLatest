<?php

namespace App\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Scheme;

class StrictPolicy extends Policy
{
    public function configure(): void
    {
        $nonce = csp_nonce();

        $this
            ->addDirective(Directive::DEFAULT, [Keyword::SELF])

            // Scripts: allow self, nonce, and external CDNs
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                'nonce-'.$nonce,
                'https://cdn.jsdelivr.net',
                'https://cdnjs.cloudflare.com',
                'https://stackpath.bootstrapcdn.com',
                'https://code.jquery.com',
                'https://unpkg.com',
                'https://cdn.datatables.net', // ADDED: DataTables
            ])

            // Styles: allow self, nonce, and CDNs
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                'nonce-'.$nonce,
                'https://fonts.googleapis.com',
                'https://cdn.jsdelivr.net',
                'https://cdnjs.cloudflare.com',
                'https://stackpath.bootstrapcdn.com',
                'https://use.fontawesome.com',
                'https://cdn.datatables.net', // ADDED: DataTables
            ])

            // Images: allow data, https, http, blob
            ->addDirective(Directive::IMG, [
                Keyword::SELF,
                'data:',
                'https:',
                'http:',
                'blob:',
                'https://diaper-plasma-lifting.ngrok-free.dev',
            ])

            // Fonts
            ->addDirective(Directive::FONT, [
                Keyword::SELF,
                'https://fonts.gstatic.com',
                'https://cdn.jsdelivr.net',
                'https://cdnjs.cloudflare.com',
                'data:',
            ])

            // Connect (for AJAX, WebSockets, etc.)
            ->addDirective(Directive::CONNECT, [
                Keyword::SELF,
                'https://diaper-plasma-lifting.ngrok-free.dev',
                'wss://diaper-plasma-lifting.ngrok-free.dev',
                'https://api.puter.com',
            ])

            // Frame sources
            ->addDirective(Directive::FRAME, [
                Keyword::SELF,
                'https://diaper-plasma-lifting.ngrok-free.dev',
            ])

            // Form actions - allow self and the ngrok domain
            ->addDirective(Directive::FORM_ACTION, [
                Keyword::SELF,
                'https://diaper-plasma-lifting.ngrok-free.dev',
                'https://diaper-plasma-lifting.ngrok-free.dev/login',
                'https://diaper-plasma-lifting.ngrok-free.dev/register',
            ])

            // Base URI
            ->addDirective(Directive::BASE, [Keyword::SELF])

            // Object/Embed
            ->addDirective(Directive::OBJECT, [Keyword::NONE])

            // Manifest
            ->addDirective(Directive::MANIFEST, [Keyword::SELF])

            // Worker
            ->addDirective(Directive::WORKER, [Keyword::SELF, 'blob:'])

            // Child sources
            ->addDirective(Directive::CHILD, [Keyword::SELF])

            // Frame ancestors
            ->addDirective(Directive::FRAME_ANCESTORS, [Keyword::SELF])

            // Media
            ->addDirective(Directive::MEDIA, [Keyword::SELF])

            // Prefetch
            ->addDirective(Directive::PREFETCH, [Keyword::SELF]);
    }
}