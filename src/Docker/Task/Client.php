<?php

declare(strict_types=1);

namespace Docker\Task;

use Curl\Curl;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Task
 */
class Client
{
    private const BASE_URL = '/tasks';

    private $curl;

    private $url;

    public function __construct(Curl $curl, string $docker_host)
    {
        $this->curl = $curl;

        $this->url = $docker_host.self::BASE_URL;
    }

    /**
     * @param array $filters
     *
     * desired-state=(running | shutdown | accepted)
     * id=<task id>
     * label=key or label="key=value"
     * name=<task name>
     * node=<node id or name>
     * service=<service name>
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function list(array $filters = [])
    {
        return $this->curl->get($this->url.'?'.http_build_query([
                    'filters' => $filters,
                ]
            )
        );
    }

    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function inspect(string $id)
    {
        return $this->curl->get($this->url.'/'.$id);
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
     *
     * @see
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
        $data = [
            'details' => $details,
            'follow' => $follow,
            'stdout' => $stdout,
            'stderr' => $stderr,
            'since' => $since,
            'timestamps' => $timestamps,
            'tail' => $tail,
        ];

        $url = $this->url.'/'.$id.'/logs?'.http_build_query($data);

        return $this->curl->get($url);
    }
}
