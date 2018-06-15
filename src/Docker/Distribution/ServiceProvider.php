<?php

declare(strict_types=1);

namespace Docker\Distribution;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['distribution'] = function ($app) {
            return new Client($app->curl, $app->docker_host);
        };
    }
}
