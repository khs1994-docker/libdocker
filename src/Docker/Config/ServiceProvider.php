<?php

declare(strict_types=1);

namespace Docker\Config;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['config'] = function ($app) {
            return new Config($app['config'], $app['docker_host']);
        };
    }
}
