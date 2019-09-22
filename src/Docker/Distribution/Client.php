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
     * Get image information from the registry.
     *
     * Return image digest and platform information by contacting the registry.
     *
     * @param string $imageName
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function info(string $imageName)
    {
        return $this->curl->get($this->url.'/distribution/'.$imageName.'/json');
    }
}
