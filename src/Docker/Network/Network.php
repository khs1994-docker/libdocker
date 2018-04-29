<?php

namespace Docker;

class Network
{
    const TYPE = 'networks';

    const BASE_URL = '/'.self::TYPE;

    use Request;

    // list

    public function inspect(string $id, bool $verbose = false, $scope = null)
    {
        if ($scope) {
            array_key_exists($scope, ['swarm', 'global', 'local']) or die("$scope error");
        }
        $data = [
            'verbose' => $verbose,
            'scope' => $scope
        ];

        $url = self::BASE_URL.'/'.$id.'/?'.http_build_query($data);

        return $this->request($url);
    }

    // remove

    // create

    public function connect(string $id, string $container, array $endpointConfig)
    {
        $url = self::BASE_URL.'/'.$id.'/connect';

        $request = json_encode(array_merge(['Container' => $container], $endpointConfig));

        return $this->request($url, 'post', $request);
    }

    public function disConnect(string $id, string $container, bool $force = false)
    {
        $data = [
            'force' => $force,
            'container' => $container
        ];

        $url = self::BASE_URL.'/'.$id.'/disconnect';

        $request = json_encode($data);

        return $this->request($url, 'post', $request);
    }

    // prune

    private function delete()
    {

    }

}