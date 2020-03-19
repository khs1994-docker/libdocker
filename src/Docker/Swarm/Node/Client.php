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
     * id=<node id>
     * label=<engine label>
     * membership=(accepted|pending)`
     * name=<node name>
     * role=(manager|worker)`
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(array $filters = [])
    {
        $data = [
            'filters' => json_encode($filters),
        ];

        $url = $this->url.'?'.http_build_query($data);

        return $this->curl->get($url);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function inspect(string $id)
    {
        return $this->curl->get($this->url.'/'.$id);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function delete(string $id, bool $force = false)
    {
        return $this->curl->delete($this->url.'/'.$id.'?'.http_build_query(['force' => $force]));
    }

    /**
     * @param string $role
     * @param string $availability
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(string $id,
                           int $version,
                           string $name,
                           array $labels = null,
                           string $role = null,
                           string $availability = null)
    {
        $url = self::BASE_URL.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        $request = [
            'Name' => $name,
            'Labels' => $labels,
            'Role' => $role,
            'Availability' => $availability,
        ];

        return $this->curl->post($url, json_encode($request));
    }
}
