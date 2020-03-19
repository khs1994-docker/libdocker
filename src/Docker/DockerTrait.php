<?php

declare(strict_types=1);

namespace Docker;

use Curl\Curl;

trait DockerTrait
{
    private $curl;

    private $url;

    private static $header = [
        'Content-Type' => 'application/json;charset=utf8',
    ];

    /**
     * Volume constructor.
     */
    public function __construct(Curl $curl, string $docker_host)
    {
        $this->curl = $curl;

        $this->url = $docker_host.self::BASE_URL;
    }
}
