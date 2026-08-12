<?php

return [
    /*
     * The policy class that determines which CSP headers will be set.
     * This is the only key the package uses for the enforce policy.
     */
    'policy' => App\Csp\StrictPolicy::class,

    /*
     * Policy for report‑only mode (optional).
     * Set to null to disable report‑only.
     */
    'report_only_policy' => null,

    /*
     * Environments where report‑only policy should be used instead of enforce.
     */
    'report_only_policy_environments' => [
        'local',
        'testing',
    ],

    /*
     * Enable nonce support – set to true for better security
     */
    'nonce' => true,

    /*
     * Additional nonces
     */
    'nonces' => [],

    /*
     * The URI to report CSP violations to.
     */
    'report_uri' => env('CSP_REPORT_URI', '/csp-report'),

    /*
     * Whether CSP is enabled.
     */
    'enabled' => env('CSP_ENABLED', true),
];
