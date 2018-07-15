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

    private $base_url;

    private $curl;

    public function __construct(Curl $curl, string $docker_hsot)
    {
        $this->base_url = $docker_hsot.self::BASE_URL;
        $this->curl = $curl;
    }

    /**
     * @param array $filters
     *
     * capability=<capability name>
     * enable=<true>|<false>
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(array $filters = [])
    {
        return $this->curl->get($this->base_url.'?'.http_build_query([
                    'filters' => json_encode($filters),
                ]
            )
        );
    }

    /**
     * @param string $remote
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getPrivileges(string $remote)
    {
        $url = $this->base_url.'/privileges?'.http_build_query(['remote' => $remote]);

        return $this->curl->get($url);
    }

    /**
     * @param string $remote
     * @param string $name
     * @param string $auth
     * @param array  $request
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function install(string $remote,
                            string $name,
                            ?string $auth,
                            array $request)
    {
        $url = $this->base_url.'/pull?'.http_build_query([
                    'remote' => $remote,
                    'name' => $name,
                ]
            );

        $header = [];

        if ($auth) {
            $header = [
                ['X-Registry-Auth' => $auth],
            ];
        }

        return $this->curl->post($url, json_encode($request), $header);
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
        $url = $this->base_url.'/'.$name.'/json';

        return $this->curl->get($url);
    }

    /**
     * @param string $name
     * @param bool   $force
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function remove(string $name, bool $force = false)
    {
        return $this->curl->delete($this->base_url.'/'.$name.'?'.http_build_query([
                    'force' => $force,
                ]
            )
        );
    }

    /**
     * @param string $name
     * @param int    $timeout
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function enable(string $name, int $timeout = 0)
    {
        return $this->curl->post($this->base_url.'/'.$name.'/enable?'.http_build_query([
                    'timeout' => $timeout,
                ]
            )
        );
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function disable(string $name)
    {
        return $this->curl->post($this->base_url.'/'.$name.'/disable');
    }

    /**
     * @param string $local_name
     * @param string $remote
     * @param string $auth
     * @param array  $request
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function upgrade(string $local_name,
                            string $remote,
                            string $auth,
                            array $request)
    {
        $url = $this->base_url.'/'.$local_name.'/upgrade?'.http_build_query([
                    'remote' => $remote,
                ]
            );

        $header = [];

        if ($auth) {
            $header = ['X-Registry-Auth' => $auth];
        }

        return $this->curl->post($url, json_encode($request), $header);
    }

    /**
     * @param string $name
     * @param string $request
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function create(string $name, string $request)
    {
        return $this->curl->post($this->base_url.'/create?'.http_build_query([
                    'name' => $name,
                ]
            ), $request
        );
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function push(string $name)
    {
        return $this->curl->post($this->base_url.'/'.$name.'/push');
    }

    /**
     * @param       $name
     * @param array $request
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function config($name, array $request)
    {
        return $this->curl->post($this->base_url.'/'.$name.'/set', json_encode($request));
    }
}
