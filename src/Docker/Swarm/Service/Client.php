<?php

declare(strict_types=1);

namespace Docker\Swarm\Service;

use Docker\DockerTrait;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Service
 */
class Client
{
    use DockerTrait;

    const BASE_URL = '/services';

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

    /**
     * @param string     $auth
     * @param string     $name
     * @param array|null $labels
     * @param array      $taskTemplate
     * @param array      $mode
     * @param array      $updateConfig
     * @param array      $rollbackConfig
     * @param array      $networks
     * @param array      $endpointSpec
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function create(string $auth,
                           string $name,
                           array $labels = null,
                           array $taskTemplate,
                           array $mode,
                           array $updateConfig,
                           array $rollbackConfig,
                           array $networks,
                           array $endpointSpec)
    {
        if ($auth) {
            $header['X-Registry-Auth'] = $auth;
        }
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'TaskTemplate' => $taskTemplate,
            'Mode' => $mode,
            'UpdateConfig' => $updateConfig,
            'RollbackConfig' => $rollbackConfig,
            'Networks' => $networks,
            'EndpointSpec' => $endpointSpec,
        ];
        $url = self::BASE_URL.'/create';

        return $this->curl->post($url, json_encode($data), $header);
    }

    /**
     * @param string $id
     * @param bool   $insertDefaults
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function inspect(string $id, bool $insertDefaults = false)
    {
        $url = self::BASE_URL.'/'.$id.'/?'.http_build_query(['insertDefaults' => $insertDefaults]);

        return $this->curl->get($url);
    }

    public function delete(): void
    {
    }

    /**
     * @param string $id
     * @param int    $version
     * @param string $registryAuthFrom
     * @param string $rollback
     * @param string $auth
     * @param array  $request_body
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update(string $id,
                           int $version,
                           string $registryAuthFrom,
                           string $rollback,
                           string $auth,
                           array $request_body)
    {
        $data = [
            'version' => $version,
            'registryAuthFrom' => $registryAuthFrom,
            'rollback' => $rollback,
        ];

        $header = [];

        if ($auth) {
            $header[' X-Registry-Auth'] = $auth;
        }

        $url = self::BASE_URL.'/'.$id.'/update?'.http_build_query($data);

        $request = json_encode($request_body);

        return $this->curl->post($url, $request, $header);
    }

    /**
     * @param string $id
     * @param bool   $details
     * @param bool   $follow
     * @param bool   $stdout
     * @param bool   $stderr
     * @param int    $since
     * @param bool   $timestamps
     * @param string $tail
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getLog(string $id,
                           bool $details = false,
                           bool $follow = false,
                           bool $stdout = false,
                           bool $stderr = false,
                           int $since = 0,
                           bool $timestamps = false,
                           string $tail = 'all')
    {
        $data = [
            'details' => $details,
            'follow' => $follow,
            'stdout' => $stdout,
            'stderr' => $stderr,
            'since' => $since,
            'timestamps' => $timestamps,
            'tail' => $tail,
        ];

        $url = self::BASE_URL.'/'.$id.'/logs?'.http_build_query($data);

        return $this->curl->get($url);
    }
}
