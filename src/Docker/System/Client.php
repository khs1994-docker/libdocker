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
    public function checkAuthConfig($username, $password, $email = null, $serverAddress = 'https://index.docker.io/v1/')
    {
        $url = $this->url.'/auth';

        $data = [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'serveraddress' => $serverAddress,
        ];

        $request = json_encode(array_filter($data));

        return $this->curl->post($url, $request, self::$header);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getInfo()
    {
        return $this->curl->get($this->url.'/info');
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getVersion()
    {
        return $this->curl->get($this->url.'/version');
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function getArch()
    {
        $version = json_decode($this->getVersion());

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
     * @return mixed
     *
     * @throws \Exception
     */
    public function events($since, $until, $filters)
    {
        $filters_array = [];
        if ($filters) {
            $filters_array = $this->resolveFilters($filters);
        }
        $data = [
            'since' => $since,
            'until' => $until,
        ];

        $data = array_merge($data, $filters_array);

        $url = $this->url.'/events?'.http_build_query($data);

        return $this->curl->get($url);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getDataUsageInfo()
    {
        return $this->curl->get($this->url.'/system/df');
    }
}
