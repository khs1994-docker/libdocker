<?php

declare(strict_types=1);

return [
    'host' => env('DOCKER_HOST', '127.0.0.1:2375'),
    'tls_verify' => env('DOCKER_TLS_VERIFY', false),
    'cert_path' => env('DOCKER_CERT_PATH', null),
    'username' => env('DOCKER_USERNAME', null),
    'password' => env('DOCKER_PASSWORD', null),
    'registry' => env('DOCKER_REGISTRY', null),
];
