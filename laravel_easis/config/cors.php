<?php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['GET, POST, PUT, DELETE, OPTIONS'],
    'allowed_origins' => ['http://192.168.1.92:5173'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type, Authorization'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
    'origin_regex' => false,
];

