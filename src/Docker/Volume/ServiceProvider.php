<?php

declare(strict_types=1);

namespace Docker\Volume;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['volume'] = function ($app) {
            return new Volume($app['curl'], $app['docker_host']);
        };
    }
}
