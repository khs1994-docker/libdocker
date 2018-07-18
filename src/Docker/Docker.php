<?php

/** @noinspection PhpMissingParentConstructorInspection */

declare(strict_types=1);

namespace Docker;

use Curl\Curl;
use Exception;
use Pimple\Container as ServiceContainer;

/**
 * @property Swarm\Config\Client  $config
 * @property Container\Client     $container
 * @property Distribution\Client  $distribution
 * @property Image\Client         $image
 * @property Network\Client       $network
 * @property Plugin\Client        $plugin
 * @property Swarm\Secret\Client  $secret
 * @property Swarm\Client         $swarm
 * @property Swarm\Node\Client    $node
 * @property Swarm\Service\Client $service
 * @property System\Client        $system
 * @property Task\Client          $task
 * @property Volume\Client        $volume
 * @property Curl                 $curl
 * @property string               $docker_host
 *
 * @see https://docs.docker.com/engine/api/v1.37/
 */
class Docker extends ServiceContainer
{
    const DOCKER_HEALTH_STARTING = 'starting';

    const DOCKER_HEALTH_HEALTHY = 'healthy';

    const DOCKER_HEALTH_UNHEALTHY = 'unhealthy';

    const DOCKER_HEALTH_NONE = 'none';

    const DOCKER_STATUS_CREATED = 'created';

    const DOCKER_STATUS_RESTARTING = 'restarting';

    const DOCKER_STATUS_RUNNING = 'running';

    const DOCKER_STATUS_REMOVING = 'removing';

    const DOCKER_STATUS_PAUSED = 'paused';

    const DOCKER_STATUS_EXITED = 'exited';

    const DOCKER_STATUS_DEAD = 'dead';

    private static $docker;

    protected $providers = [
        Container\ServiceProvider::class,
        Distribution\ServiceProvider::class,
        Image\ServiceProvider::class,
        Network\ServiceProvider::class,
        Plugin\ServiceProvider::class,
        Swarm\Config\ServiceProvider::class,
        Swarm\Node\ServiceProvider::class,
        Swarm\Secret\ServiceProvider::class,
        Swarm\Service\ServiceProvider::class,
        Swarm\ServiceProvider::class,
        System\ServiceProvider::class,
        Task\ServiceProvider::class,
        Volume\ServiceProvider::class,
    ];

    public function __construct(array $option, Curl $curl)
    {
        $this['docker_host'] = $option['DOCKER_HOST'];

        if (1 === $option['DOCKER_TLS_VERIFY']) {
            $curl->docker($option['DOCKER_CERT_PATH']);
            if ('https://' !== substr($this['docker_host'], 0, 8)) {
                $this['docker_host'] = 'https://'.$option['DOCKER_HOST'];
            }
        }

        ini_set('max_execution_time', '0');

        $curl->setTimeout(0);

        $this['curl'] = $curl;

        $this->registerProviders();
    }

    /**
     * @param array $providers
     */
    private function registerProviders(array $providers = []): void
    {
        $providerArray = array_merge($this->providers, $providers);
        foreach ($providerArray as $provider) {
            $this->register(new $provider());
        }
    }

    /**
     * @param string      $docker_host
     * @param bool        $docker_tls_verify
     * @param string|null $docker_cert_path
     * @param string|null $docker_username
     * @param string|null $docker_password
     * @param string|null $docker_registry
     *
     * @return array
     */
    public static function createOptionArray(?string $docker_host,
                                             bool $docker_tls_verify = false,
                                             string $docker_cert_path = null,
                                             string $docker_username = null,
                                             string $docker_password = null,
                                             string $docker_registry = null)
    {
        return [
            'DOCKER_HOST' => $docker_host ?? '127.0.0.1:2375',
            'DOCKER_TLS_VERIFY' => (int) $docker_tls_verify,
            'DOCKER_CERT_PATH' => $docker_cert_path,
            'DOCKER_USERNAME' => $docker_username,
            'DOCKER_PASSWORD' => $docker_password,
            'DOCKER_REGISTRY' => $docker_registry,
        ];
    }

    /**
     * 单例模式.
     *
     * @param $option
     *
     * @return Docker
     */
    public static function docker(array $option)
    {
        // 参数可以为空，默认连接到 127.0.0.1:2375

        if (!(self::$docker instanceof self)) {
            self::$docker = new self($option, new Curl());
        }

        return self::$docker;
    }

    /**
     * @param $name
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function __get($name)
    {
        if (isset($this["$name"])) {
            return $this["$name"];
        }

        throw new Exception("Command $name not found", 404);
    }

    /**
     * @return Swarm\Config\Client
     */
    public function config()
    {
        return $this['config'];
    }

    /**
     * @return Container\Client
     */
    public function container()
    {
        return $this['container'];
    }

    /**
     * @return mixed
     */
    public function distribution()
    {
        return $this['distribution'];
    }

    /**
     * @return Image\Client
     */
    public function image()
    {
        return $this['image'];
    }

    /**
     * @return Network\Client
     */
    public function network()
    {
        return $this['network'];
    }

    /**
     * @return mixed
     */
    public function node()
    {
        return $this['node'];
    }

    /**
     * @return Plugin\Client
     */
    public function plugin()
    {
        return $this['plugin'];
    }

    /**
     * @return Swarm\Secret\Client
     */
    public function secret()
    {
        return $this['secret'];
    }

    /**
     * @return mixed
     */
    public function service()
    {
        return $this['service'];
    }

    /**
     * @return Swarm\Client
     */
    public function swarm()
    {
        return $this['swarm'];
    }

    /**
     * @return System\Client
     */
    public function system()
    {
        return $this['system'];
    }

    /**
     * @return Task\Client;
     */
    public function task()
    {
        return $this['task'];
    }

    /**
     * @return Volume\Client
     */
    public function volume()
    {
        return $this['volume'];
    }
}
