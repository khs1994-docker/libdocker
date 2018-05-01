<?php

declare(strict_types=1);

namespace Docker\Container;

use Curl\Curl;
use Docker\Module\ContainerTrait;
use Exception;

class Container
{
    use ContainerTrait;

    const TYPE = 'containers';

    /**
     * @var Curl
     */
    private static $curl;

    private static $base_url;

    private static $header = ['content-type' => 'application/json;charset=utf-8'];

    public static $filters_array = [
        'ancestor',
        'before',
        'expose',
        'exited',
        'health',
        'id',
        'isolation',
        'is-task',
        'label',
        'name',
        'network',
        'publish',
        'since',
        'status',
        'volume',
    ];

    /**
     * @param array $filters
     *
     * @return array
     *
     * @throws Exception
     */
    public static function checkFilter(array $filters)
    {
        $filters_array = [];

        foreach ($filters as $filter => $v) {
            if (!in_array($filter, static::$filters_array)) {
                throw new Exception($filter, 500);
            }

            if (is_array($v)) {
                $filters_array[$filter] = $v;
                continue;
            }

            $filters_array[$filter] = [$v];
        }

        return json_encode($filters_array);
    }

    /**
     * Container constructor.
     *
     * @param $curl
     * @param $docker_host
     *
     * @throws Exception
     */
    public function __construct($curl, $docker_host)
    {
        self::$curl = $curl;
        self::$base_url = $docker_host.'/'.self::TYPE;
    }

    /**
     * @param bool       $all
     * @param int|null   $limit
     * @param bool       $size
     * @param array|null $filters
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function list(bool $all = false, int $limit = null, bool $size = false, array $filters = null)
    {
        $filters_array = [];

        if ($filters) {
            $filters_array = ['filters' => $this->checkFilter($filters)];
        }

        $data = [
            'all' => $all,
            'limit' => $limit,
            'size' => $size,
        ];

        $data = array_merge($data, $filters_array);

        $url = self::$base_url.'/json?'.http_build_query($data);

        return self::$curl->get($url);
    }

    // TODO

    public function create(string $image, string $name = null, array $cmd = null)
    {
        $url = self::$base_url.'/'.__FUNCTION__.'?'.http_build_query(['name' => $name]);

        $data = [
            'Image' => $image,
            'Cmd' => $cmd,
        ];

        $data = $this->setContainer($data);

        var_dump($data);

        $request = json_encode($data);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * @param string      $id         ID      or name of the container
     * @param string|null $detachKeys
     *
     * @return mixed
     */
    public function start(string $id, string $detachKeys = null)
    {
        $url = self::$base_url.'/'.$id.'/start?'.http_build_query(['detachKeys' => $detachKeys]);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     * @param bool   $stream
     *
     * @return mixed
     */
    public function stats(string $id, bool $stream = false)
    {
        $url = self::$base_url.'/'.$id.'/stats?'.http_build_query(['stream' => $stream]);

        return self::$curl->get($url);
    }

    /**
     * @param string $id
     * @param bool   $size
     *
     * @return mixed
     */
    public function inspect(string $id, bool $size = false)
    {
        $url = self::$base_url.'/'.$id.'/json?'.http_build_query(['size' => $size]);

        return self::$curl->get($url);
    }

    /**
     * @param string $id
     * @param string $ps_args
     *
     * @return mixed
     */
    public function top(string $id, string $ps_args = '-ef')
    {
        $url = self::$base_url.'/'.$id.'/'.__FUNCTION__.'?'.http_build_query(['ps_args' => $ps_args]);

        return self::$curl->get($url);
    }

    /**
     * @param string $id
     * @param bool   $follow
     * @param bool   $stdout
     * @param bool   $stderr
     * @param int    $since
     * @param int    $until
     * @param bool   $timestamps
     * @param string $tail
     *
     * @return mixed
     */
    public function logs(string $id,
                         bool $follow = false,
                         bool $stdout = true,
                         bool $stderr = false,
                         int $since = 0,
                         int $until = 0,
                         bool $timestamps = false,
                         string $tail = 'all')
    {
        $data = [
            'follow' => $follow,
            'stdout' => $stdout,
            'stderr' => $stderr,
            'since' => $since,
            'until' => $until,
            'timestamps' => $timestamps,
            'tail' => $tail,
        ];

        $url = self::$base_url.'/'.$id.'/'.__FUNCTION__.'?'.http_build_query($data);

        return self::$curl->get($url);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function changes(string $id)
    {
        $url = self::$base_url.'/'.$id.'/'.__FUNCTION__;

        return self::$curl->get($url);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function export(string $id)
    {
        $url = self::$base_url.'/'.$id.'/'.__FUNCTION__;

        return self::$curl->get($url);
    }

    /**
     * TODO.
     *
     * @param string $id
     * @param int    $height
     * @param int    $width
     *
     * @return mixed
     */
    public function resize(string $id, int $height, int $width)
    {
        $data = [
            'height' => $height,
            'width' => $width,
        ];
        $url = self::$base_url.'/'.$id.'/resize?'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     * @param int    $waitTime
     *
     * @return mixed
     */
    public function stop(string $id, int $waitTime = 0)
    {
        $url = self::$base_url.'/'.$id.'/stop?'.http_build_query(['t' => $waitTime]);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     * @param int    $waitTime
     *
     * @return mixed
     */
    public function restart(string $id, int $waitTime = 0)
    {
        $url = self::$base_url.'/'.$id.'/restart?'.http_persistent_handles_clean(['t' => $waitTime]);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     * @param string $signal
     *
     * @return mixed
     */
    public function kill(string $id, string $signal = 'SIGKILL')
    {
        $url = self::$base_url.'/'.$id.'/kill?'.http_build_query(['signal' => $signal]);

        return self::$curl->post($url);
    }

    /**
     * TODO.
     *
     * @param string $id
     * @param array  $request_body
     *
     * @return mixed
     */
    public function update(string $id, array $request_body = [])
    {
        $url = self::$base_url.'/'.$id.'/update';
        $request = json_encode($request_body);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * @param string $id
     * @param string $name
     *
     * @return mixed
     */
    public function rename(string $id, string $name)
    {
        $url = self::$base_url.'/'.$id.'/rename?'.http_build_query(['name' => $name]);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function pause(string $id)
    {
        $url = self::$base_url.'/'.$id.'/pause';

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function unpause(string $id)
    {
        $url = self::$base_url.'/'.$id.'/unpause';

        return self::$curl->post($url);
    }

    /**
     * TODO.
     *
     * @param string      $id
     * @param string|null $detachKeys
     * @param bool        $logs
     * @param bool        $stream
     * @param bool        $stdin
     * @param bool        $stdout
     * @param bool        $stderr
     *
     * @return mixed
     *
     * @see https://docs.docker.com/engine/api/v1.35/#operation/ContainerAttach
     */
    public function attach(string $id,
                           string $detachKeys = null,
                           bool $logs = false,
                           bool $stream = false,
                           bool $stdin = false,
                           bool $stdout = false,
                           bool $stderr = false)
    {
        (false === $logs && false === $stream) or die('Either the stream or logs parameter must be true');

        $data = [
            'detachKeys' => $detachKeys,
            'logs' => $logs,
            'stream' => $stream,
            'stdin' => $stdin,
            'stdout' => $stdout,
            'stderr' => $stderr,
        ];

        $url = self::$base_url.'/'.$id.'/attach?'.http_build_query($data);

        return $this->restart($url, 'post');
    }

    /**
     * @param string $id
     * @param string $condition
     *
     * @return mixed
     */
    public function wait(string $id, string $condition = 'not-running')
    {
        $url = self::$base_url.'/'.$id.'/wait?'.http_build_query(['condition' => $condition]);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     * @param bool   $v
     * @param bool   $force
     * @param bool   $link
     *
     * @return mixed
     */
    public function remove(string $id, bool $v = false, bool $force = false, bool $link = false)
    {
        $data = [
            'v' => $v,
            'force' => $force,
            'link' => $link,
        ];
        $url = self::$base_url.'/'.$id.'?'.http_build_query($data);

        return self::$curl->delete($url);
    }

    /**
     * TODO.
     *
     * @param string $id
     * @param string $path
     *
     * @return mixed
     */
    public function archive(string $id, string $path)
    {
        $url = self::$base_url.'/'.$id.'/archive?'.http_build_query(['path' => $path]);

        return self::$curl->get($url);
    }

    /**
     * TODO.
     *
     * @param string $id
     * @param string $path
     * @param bool   $noOverwriteDirNonDir
     * @param string $request
     */
    public function archiveFiles(string $id, string $path, bool $noOverwriteDirNonDir, string $request): void
    {
    }

    /**
     * @param array $filters
     *
     * @return mixed
     */
    public function prune(array $filters)
    {
        $filters = [
            'filters' => '',
        ];

        $url = self::$base_url.'/prune?'.http_build_query($filters);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     * @param bool   $v
     * @param bool   $force
     * @param bool   $link
     *
     * @return mixed
     */
    public function delete(string $id, bool $v = false, bool $force = false, bool $link = false)
    {
        $url = self::$base_url.'/'.$id;

        $data = [
            'v' => $v,
            'force' => $force,
            'link' => $link,
        ];

        $url = $url.'?'.http_build_query($data);

        return self::$curl->delete($url);
    }

    /**
     * @param string     $id
     * @param array|null $cmd
     * @param array|null $env
     * @param string     $user
     * @param string     $workingDir
     * @param array      $other
     *
     * @return mixed
     */
    public function createExec(string $id,
                               array $cmd = null,
                               array $env = null,
                               string $user,
                               string $workingDir,
                               array $other)
    {
        $url = self::$base_url.'/'.$id.'/exec';

        $data = [
            'Cmd' => $cmd,
            'Env' => $env,
            'User' => $user,
            'WorkingDir' => $workingDir,
        ];

        $request = json_encode(array_merge($data, $other));

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * @param string $id
     * @param bool   $detach
     * @param bool   $tty
     *
     * @return mixed
     */
    public function startExec(string $id, bool $detach = false, bool $tty = false)
    {
        $url = self::$base_url.'/exec'.$id.'/start';

        $data = [
            'Detach' => $detach,
            'Tty' => $tty,
        ];

        $request = json_encode($data);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * TODO.
     *
     * @param string $id
     * @param int    $height
     * @param int    $width
     *
     * @return mixed
     */
    public function resizeExec(string $id, int $height, int $width)
    {
        $data = [
            'h' => $height,
            'w' => $width,
        ];

        $url = self::$base_url.'/exec'.$id.'/resize'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function inspectExec(string $id)
    {
        $url = self::$base_url.'/exec'.$id.'/json';

        return self::$curl->get($url);
    }
}
