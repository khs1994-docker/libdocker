<?php

declare(strict_types=1);

namespace Docker\Swarm;

use Curl\Curl;

class Client
{
    const BASE_URL = '/swarm';

    private $curl;

    private $url;

    private static $header = [
        'Content-Type' => 'application/json;charset=utf8',
    ];

    public function __construct(Curl $curl, string $docker_host)
    {
        $this->curl = $curl;

        $this->url = $docker_host.self::BASE_URL;
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function inspect()
    {
        $url = $this->url;

        return $this->curl->get($url);
    }

    /**
     * @param string     $listenAddr
     * @param string     $advertiseAddr
     * @param string     $dataPathAddr
     * @param bool       $forceNewCluster
     * @param array|null $spec
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function initialize(string $listenAddr,
                               string $advertiseAddr,
                               string $dataPathAddr,
                               bool $forceNewCluster,
                               array $spec = null)
    {
        $data = [
            'ListenAddr' => $listenAddr,
            'AdvertiseAddr' => $advertiseAddr,
            'DataPathAddr' => $dataPathAddr,
            'ForceNewCluster' => $forceNewCluster,
            'Spec' => $spec,
        ];

        $request = json_encode($data);

        $url = $this->url.'/init';

        return $this->curl->post($url, $request, self::$header);
    }

    /**
     * @param string     $listenAddress
     * @param string     $advertiseAddress
     * @param string     $dataPathAddress
     * @param array|null $remoteAddress
     * @param string     $joinToken
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function join(string $listenAddress,
                         string $advertiseAddress,
                         string $dataPathAddress,
                         array $remoteAddress = null,
                         string $joinToken)
    {
        $data = [
            'ListenAddr' => $listenAddress,
            'AdvertiseAddr' => $advertiseAddress,
            'DataPathAddr' => $dataPathAddress,
            'RemoteAddrs' => $dataPathAddress,
            'JoinToken' => $joinToken,
        ];

        $url = $this->url.'/join';

        $request = json_encode($data);

        return $this->curl->post($url, $request, self::$header);
    }

    /**
     * @param bool $force
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function leave(bool $force = false)
    {
        $url = $this->url.'/leave';

        return $this->curl->post($url);
    }

    // TODO

    public function update(): void
    {
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function getUnlockKey()
    {
        $url = $this->url.'/unlockkey';

        return $this->curl->get($url);
    }

    /**
     * @param string $unlockKey
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function unlock(string $unlockKey)
    {
        $url = $this->url.'/unlock';
        $request = json_encode(['UnlockKey' => $unlockKey]);

        return $this->curl->post($url, $request, self::$header);
    }

    private function list(): void
    {
    }

    private function create(): void
    {
    }

    private function prune(): void
    {
    }

    private function remove(): void
    {
    }

    private function delete(): void
    {
    }
}
