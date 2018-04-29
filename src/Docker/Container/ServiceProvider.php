<?php

namespace Docker\Container;

use Pimple\Container as ServiceContainer;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(ServiceContainer $pimple)
    {
        $pimple['container'] = function ($app) {
            return new Container($app['curl'], $app['docker_host']);
        };
    }
}
