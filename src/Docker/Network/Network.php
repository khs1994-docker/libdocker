<?php

declare(strict_types=1);

namespace Docker\Network;

use Curl\Curl;

/**
 * Class Network
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Network
 */
class Network
{
    const HEADER = [
        'Content-Type' => 'application/json;charset=utf-8',
    ];
    const TYPE = 'networks';

    const BASE_URL = '/'.self::TYPE;

    private static $curl;

    private static $base_url;

    public function __construct(Curl $curl, string $docker_host)
    {
        self::$base_url = $docker_host.self::BASE_URL;
        self::$curl = $curl;
    }

    public function list()
    {

    }

    public function inspect(string $id, bool $verbose = false, $scope = null)
    {
        if ($scope) {
            array_key_exists($scope, ['swarm', 'global', 'local']) or die("$scope error");
        }
        $data = [
            'verbose' => $verbose,
            'scope' => $scope,
        ];

        $url = self::$base_url.'/'.$id.'/?'.http_build_query($data);

        return self::$curl->get($url);
    }

    public function remove()
    {

    }

    public function create(string $name)
    {
        $url = self::$base_url.'/create';

        $request = [
            'Name' => $name,
        ];

        return self::$curl->post($url, json_encode($request), self::HEADER);
    }

    public function connect(string $id, string $container, array $endpointConfig)
    {
        $url = self::$base_url.'/'.$id.'/connect';

        $request = json_encode(array_merge(['Container' => $container], $endpointConfig));

        return self::$curl->post($url, $request);
    }

    public function disConnect(string $id, string $container, bool $force = false)
    {
        $data = [
            'force' => $force,
            'container' => $container,
        ];

        $url = self::$base_url.'/'.$id.'/disconnect';

        $request = json_encode($data);

        return self::$curl->post($url, $request);
    }

    public function prune()
    {

    }
}
