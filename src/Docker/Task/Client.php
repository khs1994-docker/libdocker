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
    const BASE_URL = '/tasks';

    private $curl;

    private $url;

    public function __construct(Curl $curl, string $docker_host)
    {
        $this->curl = $curl;

        $this->url = $docker_host.self::BASE_URL;
    }

    // list
    public function list(): void
    {
    }

    // inspect
    public function inspect(): void
    {
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

        $url = $this->url.'/'.$id.'/logs?'.http_build_query($data);

        return $this->curl->get($url);
    }
}
