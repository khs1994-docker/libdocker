<?php

declare(strict_types=1);

namespace Docker\Swarm\Node;

use Docker\DockerTrait;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Node
 */
class Client
{
    use DockerTrait;

    const BASE_URL = '/nodes';

    /**
     * @param array $filters
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(array $filters = [])
    {
        $data = [
            'filters' => $filters,
        ];

        $url = $this->url.'?'.http_build_query($data);

        return $this->curl->get($url);
    }

    public function inspect(): void
    {
    }

    public function delete(): void
    {
    }

    /**
     * @param string     $id
     * @param int        $version
     * @param string     $name
     * @param array|null $labels
     * @param string     $role
     * @param string     $availability
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(string $id,
                           int $version,
                           string $name,
                           array $labels = null,
                           string $role,
                           string $availability)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Role' => $role,
            'Availability' => $availability,
        ];
        $url = self::BASE_URL.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        return $this->curl->post($url, json_encode($data));
    }
}
