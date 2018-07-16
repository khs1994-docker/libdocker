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
     * id=<service id>
     * label=<service label>
     * mode=["replicated"|"global"]
     * name=<service name>
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(array $filters = [])
    {
        $url = $this->url.'?'.http_build_query(['filters' => json_encode($filters)]);

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
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ServiceCreate
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
        $header = [];

        if ($auth) {
            $header['X-Registry-Auth'] = $auth;
        }

        $request = array_filter([
            'Name' => $name,
            'Labels' => $labels,
            'TaskTemplate' => $taskTemplate,
            'Mode' => $mode,
            'UpdateConfig' => $updateConfig,
            'RollbackConfig' => $rollbackConfig,
            'Networks' => $networks,
            'EndpointSpec' => $endpointSpec,
        ]);

        $url = self::BASE_URL.'/create';

        return $this->curl->post($url, json_encode($request), $header);
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
        $url = self::BASE_URL.'/'.$id.'?'.http_build_query(['insertDefaults' => $insertDefaults]);

        return $this->curl->get($url);
    }

    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function delete(string $id)
    {
        return $this->curl->delete($this->url.'/'.$id);
    }

    /**
     * @param string $id
     * @param int    $version
     * @param string $registryAuthFrom If the X-Registry-Auth header is not specified, this parameter indicates where
     *                                 to find registry authorization credentials. The valid values are spec and
     *                                 previous-spec.
     * @param string $rollback
     * @param string $auth
     * @param array  $request_body
     *
     * @return mixed
     *
     * @throws \Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ServiceUpdate
     */
    public function update(string $id,
                           int $version,
                           string $registryAuthFrom = 'spec',
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
    public function logs(string $id,
                         bool $details = false,
                         bool $follow = false,
                         bool $stdout = false,
                         bool $stderr = false,
                         int $since = 0,
                         bool $timestamps = false,
                         string $tail = 'all')
    {
        $query = [
            'details' => $details,
            'follow' => $follow,
            'stdout' => $stdout,
            'stderr' => $stderr,
            'since' => $since,
            'timestamps' => $timestamps,
            'tail' => $tail,
        ];

        $url = self::BASE_URL.'/'.$id.'/logs?'.http_build_query($query);

        return $this->curl->get($url);
    }
}
