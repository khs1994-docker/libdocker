<?php

declare(strict_types=1);

namespace Docker\Network;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['network'] = function ($app) {
            return new Client($app['curl'], $app['docker_host']);
        };
    }
}
