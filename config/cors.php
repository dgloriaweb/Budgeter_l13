<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // Limit CORS headers to API routes.
    // If you later switch to Sanctum SPA-cookie auth, add 'sanctum/csrf-cookie' back.
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // Comma-separated list of allowed origins (scheme + host + optional port).
    // Example:
    // CORS_ALLOWED_ORIGINS=http://localhost:5173,https://budgeterfrontend2026.netlify.app
    'allowed_origins' => array_values(array_filter(array_map(
        static fn (string $origin): string => trim($origin),
        explode(',', env('CORS_ALLOWED_ORIGINS', env('FRONTEND_URL', 'http://localhost:5173')))
    ))),

    // Optional comma-separated regex patterns (without surrounding quotes).
    // Example:
    // CORS_ALLOWED_ORIGIN_PATTERNS=#^https://.*\\.netlify\\.app$#
    'allowed_origins_patterns' => array_values(array_filter(array_map(
        static fn (string $pattern): string => trim($pattern),
        explode(',', env('CORS_ALLOWED_ORIGIN_PATTERNS', ''))
    ))),

    // Include Authorization for Bearer-token auth.
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'Accept', 'Origin'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Token auth does not require cookies/credentials.
    'supports_credentials' => false,

];
