# Docker PHP SDK

[![GitHub stars](https://img.shields.io/github/stars/khs1994-docker/libdocker.svg?style=social&label=Stars)](https://github.com/khs1994-docker/libdocker) [![PHP from Packagist](https://img.shields.io/packagist/php-v/khs1994/docker.svg)](https://packagist.org/packages/khs1994/docker) [![GitHub (pre-)release](https://img.shields.io/github/release/khs1994-docker/libdocker/all.svg)](https://github.com/khs1994-docker/libdocker/releases) [![Build Status](https://travis-ci.org/khs1994-docker/libdocker.svg?branch=master)](https://travis-ci.org/khs1994-docker/libdocker) [![StyleCI](https://styleci.io/repos/119828346/shield?branch=master)](https://styleci.io/repos/119828346)

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
 * $ docker run -it -d -v lnmp-data:/app php:7.2.5-alpine3.7 /bin/sh
 */

$image = 'php:7.2.5-alpine3.7';

$docker_image->pull($image);

$container_id = $docker_container
  ->setHostConfig(['lnmp-data:/app'])
  ->create($image, null, '/bin/sh');

$docker_container->start($container_id);

var_dump($docker_container->logs($container_id));
```

## PHP CaaS

**Powered By [khs1994-docker/lnmp](https://github.com/khs1994-docker/lnmp)**

## CI/CD

* [Drone](https://www.khs1994.com/categories/CI/Drone/)

* [Travis CI](https://travis-ci.org/khs1994-docker/libdocker)

* [Style CI](https://styleci.io/repos/119828346)

* [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

* [Renovate](https://github.com/marketplace/renovate)

* [Dependabot](https://github.com/marketplace/dependabot)

* [Aliyun CodePipeline](https://www.aliyun.com/product/codepipeline)

* [Tencent Cloud Continuous Integration](https://cloud.tencent.com/product/cci)

* [Docker Build Powered By Tencent Cloud Container Service](https://cloud.tencent.com/product/ccs)

* [Docker Build Powered By Docker Cloud](https://cloud.docker.com)

* [Docker Build Powered By Aliyun Container Service](https://www.aliyun.com/product/containerservice)
