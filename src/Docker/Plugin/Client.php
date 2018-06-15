<?php

declare(strict_types=1);

namespace Docker\Plugin;

use Curl\Curl;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Plugin
 */
class Client
{
    const TYPE = 'plugins';

    const BASE_URL = '/'.self::TYPE;

    private static $base_url;

    private static $curl;

    public function __construct(Curl $curl, string $docker_hsot)
    {
        self::$base_url = $docker_hsot.self::BASE_URL;
        self::$curl = $curl;
    }

    public function list(): void
    {
    }

    /**
     * TODO.
     *
     * @param string $remote
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getPrivileges(string $remote)
    {
        $url = self::$base_url.'/privileges?'.http_build_query(['remote' => $remote]);

        return self::$curl->get($url);
    }

    public function install(): void
    {
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function inspect(string $name)
    {
        $url = self::BASE_URL.'/'.$name.'/json';

        return self::$curl->get($url);
    }

    public function remove(): void
    {
    }

    public function enable(string $name, int $timeout = 0): void
    {
    }

    public function disable(string $name): void
    {
    }

    public function upgrade(string $name, string $remote, string $auth, array $requestBody): void
    {
    }

    public function create(string $name, string $requestBody): void
    {
    }

    public function push(string $name): void
    {
    }

    public function config($name, $requestBody): void
    {
    }
}
