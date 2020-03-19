<?php

declare(strict_types=1);

namespace Docker\Swarm\Task;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['task'] = function ($app) {
            return new Client($app->curl, $app->docker_host);
        };
    }
}
