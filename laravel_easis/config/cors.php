<?php
return [
    'paths' => ['*'],
    'allowed_methods' => ['GET, POST, PUT, DELETE'],
    'allowed_origins' => ['http://etheron.fr'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'accept', 'X-custom-header'],
    'exposed_headers' => ['x-custom-response-header'],
    'max_age' => 0,
    'supports_credentials' => false,
];

