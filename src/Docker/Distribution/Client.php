<?php

declare(strict_types=1);

namespace Docker\Distribution;

use Docker\DockerTrait;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Distribution
 */
class Client
{
    use DockerTrait;

    const BASE_URL = null;

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getImageInfoFromRegistry(string $name)
    {
        return $this->curl->get($this->url.'/distribution/'.$name.'/json');
    }
}
