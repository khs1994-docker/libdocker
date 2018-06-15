<?php

declare(strict_types=1);

namespace Docker\Swarm\Secret;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
    }
}
