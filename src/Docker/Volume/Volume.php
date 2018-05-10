<?php

declare(strict_types=1);

namespace Docker\Volume;

use Curl\Curl;
use Exception;

class Volume
{
    const BASE_URL = '/volumes';

    private static $curl;

    private static $base_url;

    private static $header = [
        'Content-Type' => 'application/json;charset=utf8',
    ];

    /**
     * Volume constructor.
     *
     * @param Curl   $curl
     * @param string $docker_host
     */
    public function __construct(Curl $curl, string $docker_host)
    {
        self::$curl = $curl;

        self::$base_url = $docker_host.self::BASE_URL;
    }

    /**
     * @param array $filters
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/VolumeList
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function list(array $filters = null)
    {
        if ($filters) {
            $filters_array = [];

            foreach ($filters as $k => $v) {
                if (!in_array($k, ['dangling', 'driver', 'label', 'name'], true)) {
                    throw new Exception('Volume List Filters Not Found', 404);
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

        $url = self::$base_url.'?'.http_build_query(['filters' => json_encode($filters_array)]);

        return self::$curl->get($url);
    }

    /**
     * @param string     $name
     * @param string     $drive
     * @param array|null $driveOpts
     * @param array      $labels
     *
     * @return mixed
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/VolumeCreate
     */
    public function create(string $name, string $drive = null, array $driveOpts = null, array $labels = null)
    {
        $url = self::$base_url.'/create';

        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'DriverOpts' => $driveOpts,
            'Driver' => $drive,
        ];

        return self::$curl->post($url, json_encode($data), self::$header);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function inspect(string $name)
    {
        $url = self::$base_url.'/'.$name;

        return self::$curl->get($url);
    }

    /**
     * @param string $name
     * @param bool   $force
     *
     * @return mixed
     */
    public function remove(string $name, bool $force = false)
    {
        $url = self::$base_url.'/'.$name.'?'.http_build_query(['force' => $force]);

        return self::$curl->delete($url);
    }

    /**
     * @param array|null $filters
     *
     * @return mixed
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/VolumePrune
     */
    public function prune(array $filters = null)
    {
        $filters_array = [];

        if ($filters) {
            foreach ($filters as $k => $v) {
                if (is_array($v)) {
                    $filters_array[$k] = $v;
                } else {
                    $filters_array[$k] = [$v];
                }
            }
        } else {
            $filters_array = null;
        }

        $url = self::$base_url.'/prune?'.http_build_query(['filters' => json_encode($filters_array)]);

        return self::$curl->post($url);
    }
}
