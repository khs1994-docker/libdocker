<?php

declare(strict_types=1);

namespace Docker\Swarm\Config;

use Curl\Curl;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Config
 */
class Client
{
    private $header = [
        'Content-Type' => 'application/json;charset=utf-8',
    ];

    const BASE_URL = '/configs';

    private $url;

    private $curl;

    public function __construct(Curl $curl, string $docker_host)
    {
        $this->url = $docker_host.self::BASE_URL;
        $this->curl = $curl;
    }

    /**
     * @param array $filters
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(array $filters = [])
    {
        $data = [
            'filters' => '',
        ];

        $url = $this->url.'?'.http_build_query($data);

        return $this->curl->get($url);
    }

    /**
     * @param string $name
     * @param array  $labels
     * @param string $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function create(string $name, array $labels = [], string $data)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
        ];

        $url = $this->url.'/create';

        return $this->curl->post($url, json_encode($data), $this->header);
    }

    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function inspect(string $id)
    {
        $url = $this->url.'/'.$id;

        return $this->curl->get($url);
    }

    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function delete(string $id)
    {
        $url = $this->url.'/'.$id;

        return $this->curl->delete($url);
    }

    /**
     * @param string $id
     * @param int    $version
     * @param string $name
     * @param array  $labels
     * @param string $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(string $id,
                           int $version,
                           string $name,
                           array $labels = [],
                           string $data)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
        ];

        $url = $this->url.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        return $this->curl->post($url, json_encode($data));
    }
}