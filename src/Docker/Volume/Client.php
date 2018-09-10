<?php

declare(strict_types=1);

namespace Docker\Volume;

use Curl\Curl;
use Exception;

/**
 * Class Client.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Volume
 */
class Client
{
    const BASE_URL = '/volumes';

    private $curl;

    private $base_url;

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
        $this->curl = $curl;

        $this->base_url = $docker_host.self::BASE_URL;
    }

    /**
     * @param array $filters
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/VolumeList
     */
    public function list(array $filters = [])
    {
        if ($filters) {
            $filters_array = [];

            foreach ($filters as $k => $v) {
                if (!\in_array($k, ['dangling', 'driver', 'label', 'name'], true)) {
                    throw new Exception('Volume List Filters Not Found', 404);
                }

                if (\is_array($v)) {
                    $filters_array[$k] = $v;
                } else {
                    $filters_array[$k] = [$v];
                }
            }
        } else {
            $filters_array = null;
        }

        $url = $this->base_url.'?'.http_build_query(['filters' => json_encode($filters_array)]);

        return $this->curl->get($url);
    }

    /**
     * @param string     $name
     * @param string     $drive
     * @param array|null $driveOpts
     * @param array      $labels
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/VolumeCreate
     */
    public function create(string $name, string $drive = null, array $driveOpts = null, array $labels = null)
    {
        $url = $this->base_url.'/create';

        $data = array_filter([
            'Name' => $name,
            'Labels' => $labels,
            'DriverOpts' => $driveOpts,
            'Driver' => $drive,
        ]);

        return $this->curl->post($url, json_encode($data), self::$header);
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function inspect(string $name)
    {
        $url = $this->base_url.'/'.$name;

        return $this->curl->get($url);
    }

    /**
     * @param string $name
     * @param bool   $force
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function remove(string $name, bool $force = false)
    {
        $url = $this->base_url.'/'.$name.'?'.http_build_query(['force' => $force]);

        return $this->curl->delete($url);
    }

    /**
     * @param array|null $filters
     *
     * label (label=<key>, label=<key>=<value>, label!=<key>, or label!=<key>=<value>)
     *
     * Prune volumes with (or without, in case label!=... is used) the specified labels.
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/VolumePrune
     */
    public function prune(array $filters = [])
    {
        $filters_array = [];

        if ($filters) {
            foreach ($filters as $k => $v) {
                if (\is_array($v)) {
                    $filters_array[$k] = $v;
                } else {
                    $filters_array[$k] = [$v];
                }
            }
        } else {
            $filters_array = null;
        }

        $url = $this->base_url.'/prune?'.http_build_query(['filters' => json_encode($filters_array)]);

        return $this->curl->post($url);
    }
}
