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

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // QUAN TRỌNG: Cho phép tất cả các phương thức, bao gồm cả OPTIONS

    'allowed_origins' => ['*'], // Cho phép tất cả các nguồn gốc (an toàn cho môi trường phát triển)

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // QUAN TRỌNG: Cho phép tất cả các header

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // QUAN TRỌNG: Bắt buộc phải là true để session hoạt động

];
