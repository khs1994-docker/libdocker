<?php

namespace Docker\Image;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['image'] = function ($app) {
            return new Image($app['curl'], $app['docker_host']);
        };
    }
}
