<?php

declare(strict_types=1);

namespace Docker\Config;

use Curl\Curl;

class Config
{
    const HEADER = [
        'Content-Type' => 'application/json;charset=utf-8',
    ];

    const TYPE = 'configs';

    const BASE_URL = '/'.self::TYPE;

    private static $base_url;

    private static $curl;

    public function __construct(Curl $curl, string $docker_host)
    {
        self::$base_url = $docker_host.self::BASE_URL;
        self::$curl = $curl;
    }

    public function list()
    {

    }

    public function create(string $name, array $labels, string $data)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
        ];

        $url = self::$base_url.'/create';

        return self::$curl->post($url, json_encode($data), self::HEADER);
    }

    public function update(string $id,
                           int $version,
                           string $name,
                           array $labels,
                           string $data)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
        ];

        $url = self::BASE_URL.'/'.$id.'/update'.http_build_query(['version' => $version]);

        return self::$curl->post($url, json_encode($data));
    }
}
