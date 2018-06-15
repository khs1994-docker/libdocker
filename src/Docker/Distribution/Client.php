<?php

declare(strict_types=1);

namespace Docker\Distribution;

use Docker\DockerTrait;

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
