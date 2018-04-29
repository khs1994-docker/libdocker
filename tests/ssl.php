<?php

require __DIR__.'/../vendor/autoload.php';

use Docker\Docker;

define('DOCKER_HOST', '127.0.0.1:2375');

//define('DOCKER_HOST', 'https://192.168.57.110:2376');

// Docker Daemon 是否启用了 TLS 验证

define('DOCKER_TLS_VERIFY', 1);

// define('DOCKER_TLS_VERIFY', 0);

define('DOCKER_CERT_PATH', __DIR__.'/Docker/ssl');

//define('DOCKER_CERT_PATH','/etc/docker/ssl');

define('DOCKER_USER', '');

define('DOCKER_PASSWORD', '');

define('DOCKER_REGISTRY', '');

$option = [
    'DOCKER_HOST' => DOCKER_HOST,
    'DOCKER_TLS_VERIFY' => DOCKER_TLS_VERIFY,
    'DOCKER_CERT_PATH' => DOCKER_CERT_PATH
];

$docker = Docker::docker($option);

$output = $docker->container->list(false,null,false,['status'=>'exited',"network"=>"1"]);

var_dump($output);

//var_dump($docker->container());

//$docker = Docker::docker();
