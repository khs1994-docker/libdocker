<?php

declare(strict_types=1);

return [
    'default' => env('PHP_DOCKER_HOSTNAME', 'default'),

    // global config
    'timeout' => env('PHP_DOCKER_TIMEOUT', 0),
    'tls_verify' => env('PHP_DOCKER_TLS_VERIFY', false),
    'cert_path' => env('PHP_DOCKER_CERT_PATH', null),
    'username' => env('PHP_DOCKER_USERNAME', null),
    'password' => env('PHP_DOCKER_PASSWORD', null),
    'registry' => env('PHP_DOCKER_REGISTRY', null),

    'hosts' => [
        'default' => [
            'host' => env('PHP_DOCKER_HOST', '127.0.0.1:2375'),
            'tls_verify' => env('PHP_DOCKER_TLS_VERIFY', false),
            'cert_path' => env('PHP_DOCKER_CERT_PATH', null),
            'username' => env('PHP_DOCKER_USERNAME', null),
            'password' => env('PHP_DOCKER_PASSWORD', null),
            'registry' => env('PHP_DOCKER_REGISTRY', null),
            'timeout' => env('PHP_DOCKER_TIMEOUT', 0),
        ],

        'other-host' => [
            'host' => env('PHP_DOCKER_OTHER_HOST', '123.206.62.20:2375'),
        ],
    ],
];
