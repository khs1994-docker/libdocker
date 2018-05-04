<?php

declare(strict_types=1);

namespace Docker\Network;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['network'] = function ($app) {
            return new Network($app['curl'], $app['docker_host']);
        };
    }
}
