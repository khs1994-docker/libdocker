<?php

declare(strict_types=1);

namespace Docker;

use Curl\Curl;

trait DockerTrait
{
    private $curl;

    private $url;

    /**
     * Volume constructor.
     *
     * @param Curl   $curl
     * @param string $docker_host
     */
    public function __construct(Curl $curl, string $docker_host)
    {
        $this->curl = $curl;

        $this->url = $docker_host.self::BASE_URL;
    }
}
