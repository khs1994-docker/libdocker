<?php

declare(strict_types=1);

namespace Docker\Swarm;

use Curl\Curl;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Swarm
 */
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
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/SwarmInit
     */
    public function initialize(string $advertiseAddr,
                               string $listenAddr = '0.0.0.0:2377',
                               string $dataPathAddr = null,
                               bool $forceNewCluster = false,
                               array $spec = null)
    {
        $data = array_filter([
            'ListenAddr' => $listenAddr,
            'AdvertiseAddr' => $advertiseAddr,
            'DataPathAddr' => $dataPathAddr,
            'ForceNewCluster' => $forceNewCluster,
            'Spec' => $spec,
        ]);

        $request = json_encode($data);

        $url = $this->url.'/init';

        return $this->curl->post($url, $request, self::$header);
    }

    /**
     * @param string $listenAddress
     * @param string $advertiseAddress
     * @param string $dataPathAddress
     * @param string $remoteAddress
     * @param string $joinToken
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function join(string $listenAddress,
                         string $advertiseAddress,
                         string $dataPathAddress,
                         string $remoteAddress,
                         string $joinToken)
    {
        $data = [
            'ListenAddr' => $listenAddress,
            'AdvertiseAddr' => $advertiseAddress,
            'DataPathAddr' => $dataPathAddress,
            'RemoteAddrs' => $remoteAddress,
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
        $url = $this->url.'/leave?'.http_build_query(['force' => $force]);

        return $this->curl->post($url);
    }

    /**
     * @param int    $version
     * @param bool   $rotateWorkerToken
     * @param bool   $rotateManagerToken
     * @param bool   $rotateManagerUnlockKey
     * @param string $name
     * @param array  $labels
     * @param array  $orchestration
     * @param array  $raft
     * @param array  $dispatcher
     * @param array  $caConfig
     * @param array  $encryptionConfig
     * @param array  $taskDefaults
     *
     * @return mixed
     *
     * @throws \Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/SwarmUpdate
     */
    public function update(int $version,
                           string $name,
                           bool $rotateWorkerToken = false,
                           bool $rotateManagerToken = false,
                           bool $rotateManagerUnlockKey = false,
                           array $labels = [],
                           array $orchestration = [],
                           array $raft = [],
                           array $dispatcher = [],
                           array $caConfig = [],
                           array $encryptionConfig = [],
                           array $taskDefaults = [])
    {
        $url = $this->url.'/update?'.http_build_query([
                    'version' => $version,
                    'rotateWorkerToken' => $rotateWorkerToken,
                    'rotateManagerToken' => $rotateManagerToken,
                    'rotateManagerUnlockKey' => $rotateManagerUnlockKey,
                ]
            );

        $request = array_filter([
            'Name' => $name,
            'Labels' => $labels,
            'Orchestration' => $orchestration,
            'raft' => $raft,
            'Dispatcher' => $dispatcher,
            'CAConfig' => $caConfig,
            'EncryptionConfig' => $encryptionConfig,
            'TaskDefaults' => $taskDefaults,
        ]);

        return $this->curl->post($url, json_encode($request));
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
}
