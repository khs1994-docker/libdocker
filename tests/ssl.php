<?php

require __DIR__.'/../vendor/autoload.php';

use Docker\Docker;

$option = Docker::createOptionArray('127.0.0.1:2375');

$container = Docker::docker($option)->container;

$output = $container->create('php:7.2.5-fpm-alpine3.7', null, ['sh']);

var_dump($output);

//var_dump($docker->container());

//$docker = Docker::docker();
