<?php

declare(strict_types=1);

namespace Docker\Swarm;

class Swarm
{
    const BASE_URL = '/swarm';

    public function inspect()
    {
        $url = self::BASE_URL;

        return $this->request($url);
    }

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

        $url = self::BASE_URL.'/init';

        return $this->request($url, 'post', $request, $this->header);
    }

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

        $url = self::BASE_URL.'/join';

        $request = json_encode($data);

        return $this->request($url, 'post', $request, $this->header);
    }

    public function leave(bool $force = false)
    {
        $url = self::BASE_URL.'/leave';

        return $this->request($url, 'post');
    }

    // TODO

    public function update(): void
    {
    }

    public function getUnlockKey()
    {
        $url = self::BASE_URL.'/unlockkey';

        return $this->request($url);
    }

    public function unlock(string $unlockKey)
    {
        $url = self::BASE_URL.'/unlock';
        $request = json_encode(['UnlockKey' => $unlockKey]);

        return $this->request($url, 'post', $request, $this->header);
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
