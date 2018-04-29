<?php

namespace Docker;

use Exception;
use Pimple\Container as ServiceContainer;

use Curl\Curl;

/**
 * @property Container\Container $container
 * @property Config\Config       $config
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
        Container\ServiceProvider::class
    ];

    public function __construct(array $option, Curl $curl)
    {
        $this['docker_host'] = $option['DOCKER_HOST'];

        if (1 === $option['DOCKER_TLS_VERIFY']) {
            $curl->docker($option['DOCKER_CERT_PATH']);
        }

        $this['curl'] = $curl;

        $this->registerProviders();
    }

    /**
     * @param array $providers
     */
    private function registerProviders(array $providers = [])
    {
        $providerArray = array_merge($this->providers, $providers);
        foreach ($providerArray as $provider) {
            $this->register(new $provider);
        }
    }

    /**
     * 单例模式
     *
     * @param $option
     *
     * @return Docker
     */
    public static function docker(array $option)
    {
        // 参数可以为空，默认连接到 127.0.0.1:2375

        if (!(self::$docker instanceof Docker)) {
            self::$docker = new self($option, new Curl());
        }

        return self::$docker;
    }

    /**
     * @param $name
     *
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        if (isset($this["$name"])) {

            return $this["$name"];
        }

        throw new Exception("Command $name not found", 404);
    }

    // 接收参数

    public static function build(array $config)
    {
        return new Build();
    }

    public static function client(array $config)
    {
        return new Client();
    }

    public static function config(array $config)
    {
        return new Config();
    }

    public function container()
    {
        var_dump($this['container']);
    }

    public static function daemon(array $config)
    {
        return new Daemon();
    }

    public static function image(array $config)
    {
        return new Image();
    }

    public static function network(array $config)
    {
        return new Network();
    }

    public static function node(array $config)
    {
        return new Node();
    }

    public static function plugin(array $config)
    {
        return new Plugin();
    }

    public static function secret(array $config)
    {
        return new Secret();
    }

    public static function service(array $config)
    {
        return new Service();
    }

    public static function swarm(array $config)
    {
        return new Swarm();
    }

    public static function system(array $config)
    {
        return new System();
    }

    public static function task(array $config)
    {
        return new Task();
    }

    public static function volume(array $config)
    {
        return new Volume();
    }

    // 得到任何镜像的信息

    public static function getImageInfo($name)
    {
        $url = '/distribution/'.$name.'/json';
        return self::request($url);
    }
}
