<?php

declare(strict_types=1);

namespace Docker;

/**
 * @method static Swarm\Config\Client  config()
 * @method static Container\Client     container()
 * @method static Distribution\Client  distribution()
 * @method static Image\Client         image()
 * @method static Network\Client       network()
 * @method static Plugin\Client        plugin()
 * @method static Swarm\Secret\Client  secret()
 * @method static Swarm\Client         swarm()
 * @method static Swarm\Node\Client    node()
 * @method static Swarm\Service\Client service()
 * @method static System\Client        system()
 * @method static Task\Client          task()
 * @method static Volume\Client        volume()
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return Docker::class;
    }
}
