<?php

declare(strict_types=1);

namespace Docker\Swarm\Config;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['config'] = function ($app) {
            return new Client($app['config'], $app['docker_host']);
        };
    }
}
