<?php

declare(strict_types=1);

return [
    // common config
    'timeout' => env('DOCKER_TIMEOUT', 0),
    'tls_verify' => env('DOCKER_TLS_VERIFY', false),
    'cert_path' => env('DOCKER_CERT_PATH', null),
    'username' => env('DOCKER_USERNAME', null),
    'password' => env('DOCKER_PASSWORD', null),
    'registry' => env('DOCKER_REGISTRY', null),

    'default' => [
        'host' => env('DOCKER_HOST', '127.0.0.1:2375'),
        'tls_verify' => env('DOCKER_TLS_VERIFY', false),
        'cert_path' => env('DOCKER_CERT_PATH', null),
        'username' => env('DOCKER_USERNAME', null),
        'password' => env('DOCKER_PASSWORD', null),
        'registry' => env('DOCKER_REGISTRY', null),
        'timeout' => env('DOCKER_TIMEOUT', 0),
    ],

    'my-other-host' => [
        'host' => env('DOCKER_HOST', '127.0.0.1:2375'),
    ],
];
