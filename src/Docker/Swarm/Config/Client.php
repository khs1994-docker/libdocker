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
     * id=<config id>
     * label=<key> or label=<key>=value
     * name=<config name>
     * names=<config name>
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(array $filters = [])
    {
        $query = [
            'filters' => json_encode($filters),
        ];

        $url = $this->url.'?'.http_build_query($query);

        return $this->curl->get($url);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function create(string $name, string $data, array $labels = [], array $templating = [])
    {
        $request = array_filter([
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
            'Templating' => $templating,
        ]);

        $url = $this->url.'/create';

        return $this->curl->post($url, json_encode($request), $this->header);
    }

    /**
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
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(string $id,
                           int $version,
                           string $name,
                           string $data,
                           array $labels = [],
                           array $templating = [])
    {
        $data = array_filter([
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
            'Templating' => $templating,
        ]);

        $url = $this->url.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        return $this->curl->post($url, json_encode($data));
    }
}
