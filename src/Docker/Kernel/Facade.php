<?php

declare(strict_types=1);

namespace Docker\Kernel;

/**
 * @method static \Docker\Swarm\Config\Client  config()
 * @method static \Docker\Container\Client     container()
 * @method static \Docker\Distribution\Client  distribution()
 * @method static \Docker\Image\Client         image()
 * @method static \Docker\Network\Client       network()
 * @method static \Docker\Plugin\Client        plugin()
 * @method static \Docker\Swarm\Secret\Client  secret()
 * @method static \Docker\Swarm\Client         swarm()
 * @method static \Docker\Swarm\Node\Client    node()
 * @method static \Docker\Swarm\Service\Client service()
 * @method static \Docker\System\Client        system()
 * @method static \Docker\Task\Client          task()
 * @method static \Docker\Volume\Client        volume()
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return \Docker\Docker::class;
    }
}
