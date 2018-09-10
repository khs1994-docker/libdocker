# Docker PHP SDK

[![GitHub stars](https://img.shields.io/github/stars/khs1994-docker/libdocker.svg?style=social&label=Stars)](https://github.com/khs1994-docker/libdocker) [![PHP from Packagist](https://img.shields.io/packagist/php-v/khs1994/docker.svg)](https://packagist.org/packages/khs1994/docker) [![GitHub (pre-)release](https://img.shields.io/github/release/khs1994-docker/libdocker/all.svg)](https://github.com/khs1994-docker/libdocker/releases) [![Build Status](https://travis-ci.com/khs1994-docker/libdocker.svg?branch=master)](https://travis-ci.com/khs1994-docker/libdocker) [![StyleCI](https://styleci.io/repos/119828346/shield?branch=master)](https://styleci.io/repos/119828346)  [![codecov](https://codecov.io/gh/khs1994-docker/libdocker/branch/master/graph/badge.svg)](https://codecov.io/gh/khs1994-docker/libdocker) [![](https://img.shields.io/badge/AD-%E8%85%BE%E8%AE%AF%E4%BA%91%E5%AE%B9%E5%99%A8%E6%9C%8D%E5%8A%A1-blue.svg)](https://cloud.tencent.com/redirect.php?redirect=10058&cps_key=3a5255852d5db99dcd5da4c72f05df61)

A PHP library for the Docker Engine API

* [问题反馈](https://github.com/khs1994-docker/lnmp/issues/332)

* [Docker API Docs](https://docs.docker.com/engine/api/v1.37/)

## Installation

To Use Docker PHP Library, simply:

```bash
$ composer require khs1994/docker
```

For latest commit version:

```bash
$ composer require khs1994/docker @dev
```

## Usage

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Docker\Docker;

$option = Docker::createOptionArray('127.0.0.1:2375');

// Connect TLS Docker Daemon

// $option = Docker::createOptionArray('123.123.123.133:2376',true,'/etc/docker/cert');

$docker = Docker::docker($option);

$docker_container = $docker->container;

$docker_image = $docker->image;

/*
 * $ docker run -it -d -v lnmp-data:/app php:7.2.8-fpm-alpine3.7 /bin/sh
 */

$image = 'php:7.2.8-fpm-alpine3.7';

$docker_image->pull($image);

$container_id = $docker_container
  ->setImage($image)
  ->setCmd(['/bin/sh'])
  ->setBinds(['lnmp-data:/app'])
  ->create(true);

$docker_container->start($container_id);

var_dump($docker_container->logs($container_id));
```

## Laravel

```bash
$ php artisan vendor:publish --tag=config
```

Then edit `config/docker.php`

```php
use Docker;

// call by facade
Docker::container()->list();

// call by helper function
docker()->container()->list();

// call by DI

class MyController
{
    public $docker;
    
    public function __construct(\Docker\Docker $docker)
    {
        $this->docker = $docker;
    }
    
    public function demo()
    {
        $this->docker->container()->list();
    }
}
```

## Who use it?

* [KhsCI](https://github.com/khs1994-php/khsci)

## PHP CaaS

**Powered By [khs1994-docker/lnmp](https://github.com/khs1994-docker/lnmp)**
