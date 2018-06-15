<?php

declare(strict_types=1);

namespace Docker\Network;

use Curl\Curl;
use Exception;

/**
 * Class Network.
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

    private static $filterArray = [
        'driver',
        'id',
        'label',
        'name',
        'scope',
        'type',
    ];

    public function __construct(Curl $curl, string $docker_host)
    {
        self::$base_url = $docker_host.self::BASE_URL;
        self::$curl = $curl;
    }

    /**
     * @param array $filter
     *
     * @return array|null
     *
     * @throws Exception
     */
    private static function parseListFilter(array $filter)
    {
        $filter_array = [];

        if ($filter) {
            foreach ($filter as $k => $v) {
                if (!in_array($k, self::$filterArray, true)) {
                    throw new Exception('Network Filters Not Found');
                }

                if (is_array($v)) {
                    $filter_array[$k] = $v;
                } else {
                    $filter_array[$k] = [$v];
                }
            }
        } else {
            $filter_array = null;
        }

        return json_encode($filter_array);
    }

    /**
     * @param array $filter
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkList
     */
    public function list(array $filter = null)
    {
        $filter = self::parseListFilter($filter);

        $url = self::$base_url.'/?'.http_build_query(['filters' => $filter]);

        return self::$curl->get($url);
    }

    /**
     * @param string $id
     * @param bool   $verbose
     * @param string $scope
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkInspect
     */
    public function inspect(string $id, bool $verbose = false, string $scope = null)
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

    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkDelete
     */
    public function remove(string $id)
    {
        $url = self::$base_url.'/'.$id;

        return self::$curl->delete($url);
    }

    /**
     * TODO.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkCreate
     */
    public function create(string $name)
    {
        $url = self::$base_url.'/create';

        $request = [
            'Name' => $name,
        ];

        return self::$curl->post($url, json_encode($request), self::HEADER);
    }

    /**
     * TODO.
     *
     * @param string $id
     * @param string $container
     * @param array  $endpointConfig
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkConnect
     */
    public function connect(string $id, string $container, array $endpointConfig)
    {
        $url = self::$base_url.'/'.$id.'/connect';

        $request = json_encode(array_merge(['Container' => $container], $endpointConfig));

        return self::$curl->post($url, $request);
    }

    /**
     * @param string $id
     * @param string $container
     * @param bool   $force
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkDisconnect
     */
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

    /**
     * @param array|null $filters
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkPrune
     */
    public function prune(array $filters = null)
    {
        $filters = self::checkPruneFilter($filters);

        $url = self::$base_url.'/prune?'.http_build_query(['filters' => $filters]);

        return self::$curl->post($url);
    }

    /**
     * @param array $filters
     *
     * @return array|null
     *
     * @throws Exception
     */
    private static function checkPruneFilter(array $filters)
    {
        $filters_array = [];
        if ($filters) {
            foreach ($filters as $k => $v) {
                if (!in_array($k, ['label', 'until'], true)) {
                    throw new Exception('Network Prune Filters Not Found', 404);
                }
            }

            if (is_array($v)) {
                $filters_array[$k] = $v;
            } else {
                $filters_array[$k] = [$v];
            }
        } else {
            $filters_array = null;
        }

        return json_encode($filters_array);
    }
}
