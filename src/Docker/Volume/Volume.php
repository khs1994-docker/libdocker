<?php

declare(strict_types=1);

namespace Docker\Volume;

use Curl\Curl;

class Volume
{
    const BASE_URL = '/volumes';

    private static $curl;

    private static $base_url;

    /**
     * Volume constructor.
     *
     * @param Curl   $curl
     * @param string $docker_host
     */
    public function __construct(Curl $curl, string $docker_host)
    {
        self::$curl = $curl;

        self::$base_url = $docker_host.self::BASE_URL;
    }

    // list

    // create

    // prune

    // inspect

    // remove

    private function delete(): void
    {
    }
}
