<?php

declare(strict_types=1);

namespace Docker;

use Curl\Curl;
use Exception;
use Pimple\Container as ServiceContainer;

/**
 * @version 18.06.0
 *
 * @method Swarm\Config\Client config()
 *
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
 * @property Swarm\Task\Client    $task
 * @property Volume\Client        $volume
 * @property Curl                 $curl
 * @property string               $docker_host
 *
 * @see     https://docs.docker.com/engine/api/v1.37/
 */
class Docker extends ServiceContainer
{
    private const VERSION = '18.06.0';

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

    private static $docker_connection = [];

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
        Swarm\Task\ServiceProvider::class,
        System\ServiceProvider::class,
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

        $curl->setTimeout($option['DOCKER_TIMEOUT']);

        $this['curl'] = $curl;

        $this->registerProviders();
    }

    private function registerProviders(array $providers = []): void
    {
        $providerArray = array_merge($this->providers, $providers);
        foreach ($providerArray as $provider) {
            $this->register(new $provider());
        }
    }

    /**
     * @param string $docker_host
     *
     * @return array
     */
    public static function createOptionArray(?string $docker_host,
                                             bool $docker_tls_verify = false,
                                             string $docker_cert_path = null,
                                             string $docker_username = null,
                                             string $docker_password = null,
                                             string $docker_registry = null,
                                             int $docker_timeout = 0)
    {
        return [
            'DOCKER_HOST' => $docker_host ?? '127.0.0.1:2375',
            'DOCKER_TLS_VERIFY' => (int) $docker_tls_verify,
            'DOCKER_CERT_PATH' => $docker_cert_path,
            'DOCKER_USERNAME' => $docker_username,
            'DOCKER_PASSWORD' => $docker_password,
            'DOCKER_REGISTRY' => $docker_registry,
            'DOCKER_TIMEOUT' => $docker_timeout,
        ];
    }

    public function connection(string $name = 'default')
    {
        if (!(self::$docker_connection[$name] instanceof self)) {
            self::$docker_connection[$name] = new self(self::createOptionArray(
                config('docker.app.'.$name.'.host'),
                config('docker.app.'.$name.'.tls_verify') ?? config('docker.tls_verify'),
                config('docker.app.'.$name.'.cert_path') ?? config('docker.cert_path'),
                config('docker.app.'.$name.'.username') ?? config('docker.username'),
                config('docker.app.'.$name.'.password') ?? config('docker.password'),
                config('docker.app.'.$name.'.registry') ?? config('docker.registry'),
                config('docker.app.'.$name.'.timeout') ?? config('docker.timeout')
            ), new Curl());
        }

        return self::$docker_connection[$name];
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
            $curl = new Curl();
            $curl->setHeader('Expect', '');
            self::$docker = new self($option, $curl);
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

    public function __call($name, $arguments)
    {
        return $this->$name;
    }

    public function version()
    {
        return self::VERSION;
    }
}
