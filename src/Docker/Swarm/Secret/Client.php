<?php

declare(strict_types=1);

namespace Docker\Swarm\Secret;

use Curl\Curl;

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

    public function list(): void
    {
    }

    public function create(string $name, array $labels, string $data, array $drive)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
            'Drive' => $drive,
        ];

        $url = self::$base_url.'/create';

        return self::$curl->post($url, json_encode($data), self::HEADER);
    }

    public function inspect(): void
    {
    }

    public function remove(): void
    {
    }

    public function update(string $id,
                           int $version,
                           string $name,
                           array $labels,
                           string $data,
                           array $drive)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
            'Drive' => $drive,
        ];

        $url = self::$base_url.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        return self::$curl->post($url, json_encode($data), self::HEADER);
    }
}
