<?php

declare(strict_types=1);

namespace Docker;

class Service
{
    const BASE_URL = '/services';

    use Request;

    // list

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

        return $this->request($url, 'post', json_encode($data), $header);
    }

    public function inspect(string $id, bool $insertDefaults = false)
    {
        $url = self::BASE_URL.'/'.$id.'/?'.http_build_query(['insertDefaults' => $insertDefaults]);

        return $this->request($url);
    }

    // delete

    private function remove(): void
    {
    }

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

        return $this->request($url, 'post', $request, $header);
    }

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

        return $this->request($url);
    }
}
