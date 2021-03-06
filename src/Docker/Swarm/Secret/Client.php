<?php

declare(strict_types=1);

namespace Docker\Swarm\Secret;

use Curl\Curl;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Secret
 */
class Client
{
    const HEADER = ['Content-Type' => 'application/json;charset=utf-8'];

    const TYPE = 'secrets';

    const BASE_URL = '/'.self::TYPE;

    private static $curl;

    private static $base_url;

    public function __construct(Curl $curl, string $docker_host)
    {
        self::$base_url = $docker_host.self::BASE_URL;
        self::$curl = $curl;
    }

    /**
     * @param array $filters
     *
     * id=<secret id>
     * label=<key> or label=<key>=value
     * name=<secret name>
     * names=<secret name>
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(array $filters = [])
    {
        return self::$curl->get(self::$base_url.'?'.http_build_query(['filters' => json_encode($filters)]));
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/SecretCreate
     */
    public function create(string $name, string $data, array $labels = [], array $drive = [], array $templating = [])
    {
        $data = array_filter([
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
            'Drive' => $drive,
            'Templating' => $templating,
        ]);

        $url = self::$base_url.'/create';

        return self::$curl->post($url, json_encode($data), self::HEADER);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function inspect(string $id)
    {
        return self::$curl->get(self::$base_url.'/'.$id);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function delete(string $id)
    {
        return self::$curl->delete(self::$base_url.'/'.$id);
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
                           array $drive = [],
                           array $templating = [])
    {
        $data = array_filter([
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
            'Drive' => $drive,
            'Templating' => $templating,
        ]);

        $url = self::$base_url.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        return self::$curl->post($url, json_encode($data), self::HEADER);
    }
}
