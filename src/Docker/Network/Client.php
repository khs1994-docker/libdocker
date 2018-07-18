<?php

declare(strict_types=1);

namespace Docker\Network;

use Curl\Curl;
use Exception;

/**
 * Network.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Network
 */
class Client
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
     * driver=<driver-name> Matches a network's driver.
     * id=<network-id> Matches all or part of a network ID.
     * label=<key> or label=<key>=<value> of a network label.
     * name=<network-name> Matches all or part of a network name.
     * scope=["swarm"|"global"|"local"] Filters networks by scope (swarm, global, or local).
     * type=["custom"|"builtin"] Filters networks by type. The custom keyword returns all user-defined networks.
     *
     * @return mixed 200
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkList
     */
    public function list(array $filter = [])
    {
        $filter = self::parseListFilter($filter);

        $url = self::$base_url.'/?'.http_build_query(['filters' => $filter]);

        return self::$curl->get($url);
    }

    /**
     * @param string $id
     * @param bool   $verbose Detailed inspect output for troubleshooting
     * @param string $scope   Filter the network by scope (swarm, global, or local)
     *
     * @return mixed 200
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
     * @return mixed 204
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
     * @param string $name
     * @param bool   $checkDuplicate check for networks with duplicate names
     * @param string $driver
     * @param bool   $internal
     * @param bool   $attachable     globally scoped network is manually attachable by regular containers from workers
     *                               in swarm mode
     * @param bool   $ingress
     * @param bool   $enableIPv6     enable IPv6 on the network
     * @param array  $ipam           [ "Driver" => "default", "Config" => [], "Options" => []]
     * @param array  $options        [ 'a' => 1 ]
     * @param array  $labels         [ 'k' => 'v' ]
     *
     * @return mixed 201
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkCreate
     */
    public function create(string $name,
                           bool $checkDuplicate = false,
                           string $driver = 'bridge',
                           bool $internal = true,
                           bool $attachable = false,
                           bool $ingress = false,
                           bool $enableIPv6 = false,
                           array $ipam = [],
                           array $options = [],
                           array $labels = [])
    {
        $url = self::$base_url.'/create';

        $request = array_filter([
            'Name' => $name,
            'CheckDuplicate' => $checkDuplicate,
            'Driver' => $driver,
            'Internal' => $internal,
            'Attachable' => $attachable,
            'Ingress' => $ingress,
            'IPAM' => $ipam,
            'EnableIPv6' => $enableIPv6,
            'Options' => $options,
            'Labels' => $labels,
        ]);

        return self::$curl->post($url, json_encode($request), self::HEADER);
    }

    /**
     * @param string $id
     * @param string $container      the ID or name of the container to connect to the network
     * @param array  $endpointConfig Configuration for a network endpoint.
     *                               [ 'IPAMConfig' => [], 'Links' => [] ]
     *
     * @return mixed 200
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/NetworkConnect
     */
    public function connect(string $id, string $container, array $endpointConfig = [])
    {
        $url = self::$base_url.'/'.$id.'/connect';

        $request = json_encode(array_merge([
                    'Container' => $container,
                    'EndpointConfig' => $endpointConfig,
                ]
            )
        );

        return self::$curl->post($url, $request);
    }

    /**
     * @param string $id
     * @param string $container
     * @param bool   $force
     *
     * @return mixed 200
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
     * @return mixed 200
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
                    throw new Exception('Network Prune Filters '.$k.' Not Found', 404);
                }

                if (is_array($v)) {
                    $filters_array[$k] = $v;
                } else {
                    $filters_array[$k] = [$v];
                }
            }
        } else {
            $filters_array = null;
        }

        return json_encode($filters_array);
    }
}
