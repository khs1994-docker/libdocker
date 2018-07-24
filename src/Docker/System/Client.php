<?php

declare(strict_types=1);

namespace Docker\System;

use Curl\Curl;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/System
 */
class Client
{
    private $curl;

    private $url;

    private static $header = [
        'Content-Type' => 'application/json',
    ];

    public function __construct(Curl $curl, string $docker_host)
    {
        $this->curl = $curl;

        $this->url = $docker_host;
    }

    /**
     * @param $username
     * @param $password
     * @param $email
     * @param $serverAddress
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function checkAuthConfig(string $username, string $password, string $serverAddress = 'https://index.docker.io/v1/')
    {
        $url = $this->url.'/auth';

        $data = [
            'username' => $username,
            'password' => $password,
            'serveraddress' => $serverAddress,
        ];

        $request = json_encode(array_filter($data));

        return $this->curl->post($url, $request, self::$header);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $serveraddress
     *
     * @return string
     */
    public function authJson(string $username, string $password, string $serveraddress = 'https://index.docker.io/v1/')
    {
        return base64_encode(json_encode(
                array_filter([
                        'username' => $username,
                        'password' => $password,
                        'serveraddress' => $serveraddress,
                    ]
                )
            )
        );
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function info()
    {
        return $this->curl->get($this->url.'/info');
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function version()
    {
        return $this->curl->get($this->url.'/version');
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function arch()
    {
        $version = json_decode($this->version());

        $os = $version->Os;

        $arch = $version->Arch;

        return $os.$arch;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function ping()
    {
        return $this->curl->get($this->url.'/_ping');
    }

    /**
     * @param $since
     * @param $until
     * @param $filters
     *
     * config=<string> config name or ID
     * container=<string> container name or ID
     * daemon=<string> daemon name or ID
     * event=<string> event type
     * image=<string> image name or ID
     * label=<string> image or container label
     * network=<string> network name or ID
     * node=<string> node ID
     * plugin= plugin name or ID
     * scope= local or swarm
     * secret=<string> secret name or ID
     * service=<string> service name or ID
     * type=<string> object to filter by, one of container, image, volume, network, daemon, plugin, node, service,
     * secret or config volume=<string> volume name
     *
     * @return mixed
     *
     * @throws \Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/SystemEvents
     */
    public function events(string $since, string $until, array $filters = [])
    {
        $query = [
            'since' => $since,
            'until' => $until,
            'filters' => json_encode($filters),
        ];

        $url = $this->url.'/events?'.http_build_query($query);

        return $this->curl->get($url);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function dataUsageInfo()
    {
        return $this->curl->get($this->url.'/system/df');
    }
}
