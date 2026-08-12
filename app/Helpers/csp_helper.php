<?php

if (!function_exists('csp_nonce')) {
    function csp_nonce(): string
    {
        try {
            if (app()->bound('csp.nonce')) {
                return app('csp.nonce');
            }
        } catch (\Exception $e) {
            // Fall through
        }
        return base64_encode(random_bytes(16));
    }
}
