<?php

declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

use Docker\Docker;

$option = Docker::createOptionArray('127.0.0.1:2375');

$docker = Docker::docker($option);

$container = $docker->container;

$image = $docker->image;

/*
 * docker run -it -d -v lnmp-data:/app php:7.2.5-alpine3.7 sh
 */

$output = $container->logs('e1c1449e4bc38e621273798cb4c3cb6002d46fa7a55f287fcb5e44fe36a413a0');

var_dump($output);

var_dump($container->stats('e1c1449e4bc38e621273798cb4c3cb6002d46fa7a55f287fcb5e44fe36a413a0'));

//var_dump($output);

//var_dump($docker->container());

//$docker = Docker::docker();
