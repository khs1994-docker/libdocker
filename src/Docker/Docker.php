<?php

declare(strict_types=1);

namespace Docker;

use Exception;
use Pimple\Container as ServiceContainer;
use Curl\Curl;

/**
 * @property Container\Container $container
 * @property Config\Config       $config
 * @property Image\Image         $image
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
        Image\ServiceProvider::class,
    ];

    public function __construct(array $option, Curl $curl)
    {
        $this['docker_host'] = $option['DOCKER_HOST'];

        if (1 === $option['DOCKER_TLS_VERIFY']) {
            $curl->docker($option['DOCKER_CERT_PATH']);
        }

        ini_set('max_execution_time', '100');

        $curl->setTimeout(100);

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
    public static function createOptionArray(string $docker_host,
                                             bool $docker_tls_verify = false,
                                             string $docker_cert_path = null,
                                             string $docker_username = null,
                                             string $docker_password = null,
                                             string $docker_registry = null)
    {
        return [
            'DOCKER_HOST' => $docker_host,
            'DOCKER_TLS_VERIFY' => (int)$docker_tls_verify,
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

    public function config()
    {
        return $this['config'];
    }

    /**
     * @return Container\Container
     */
    public function container()
    {
        return $this['container'];
    }

    /**
     * @return Image\Image
     */
    public function image()
    {
        return $this['image'];
    }

    /**
     * @return Network\Network
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
     * @return Plugin\Plugin
     */
    public function plugin()
    {
        return $this['plugin'];
    }

    /**
     * @return Secret\Secret
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
     * @return Swarm\Swarm
     */
    public function swarm()
    {
        return $this['swarm'];
    }

    /**
     * @return System\System
     */
    public function system()
    {
        return $this['system'];
    }

    /**
     * @return Task\Task;
     */
    public function task()
    {
        return $this['task'];
    }

    /**
     * @return Volume\Volume
     */
    public function volume()
    {
        return $this['volume'];
    }
}
