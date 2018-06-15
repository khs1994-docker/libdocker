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
     * @return mixed
     *
     * @throws \Exception
     */
    public function getImageInfoFromRegistry()
    {
        return $this->curl->get($this->url.'/distribution/{name}/json');
    }
}
