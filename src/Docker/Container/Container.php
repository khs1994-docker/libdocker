<?php /** @noinspection PhpUnusedPrivateFieldInspection */

declare(strict_types=1);

namespace Docker\Container;

use Curl\Curl;
use Error;
use Exception;

/**
 * Class Container
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Container
 */
class Container
{
    const TYPE = 'containers';

    /**
     * @var Curl
     */
    private static $curl;

    private static $base_url;

    private static $header = ['content-type' => 'application/json;charset=utf-8'];

    /**
     * @var array
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ContainerList
     */
    private static $filters_array_list = [
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
     * @var array
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ContainerPrune
     */
    private static $filters_array_prune = [
        'until',
        'label',
    ];

    /**
     * @var string
     */
    private $hostname = null;

    /**
     * @var string
     */
    private $domainname = null;

    /**
     * @var string
     */
    private $user = null;

    /**
     * @var bool
     */
    private $attachStdin = false;

    /**
     * @var bool
     */
    private $attachStdout = true;

    /**
     * @var bool
     */
    private $attachStderr = true;

    /**
     * @var array
     */
    public $ExposedPorts = [];

    /**
     * @var bool
     */
    private $tty = false;

    /**
     * @var bool
     */
    private $openStdin = false;

    /**
     * @var bool
     */
    private $stdinOnce = false;

    /**
     * @var array
     */
    private $env = [];

    private $healthcheck;

    /**
     * @var bool Windows Only
     */
    private $argsEscaped = false;

    /**
     * @var array
     */
    private $volumes = [];

    /**
     * @var string
     */
    private $workingDir = null;

    /**
     * @var array|string
     */
    private $entrypoint = null;

    /**
     * @var bool
     */
    private $networkDisabled = false;

    /**
     * @var string
     */
    private $macAddress = null;

    /**
     * @var string|array
     */
    private $onBuild = null;

    /**
     * @var array
     */
    private $labels = [];

    /**
     * @var string
     */
    private $stopSignal = 'SIGTERM';

    /**
     * @var int
     */
    private $stopTimeout = 10;

    private $hostConfig = [];

    /**
     * @var array|string
     */
    private $shell = null;

    public $inspect;

    /**
     * @param string $type
     * @param array  $filters
     *
     * @return array
     *
     * @throws Exception
     */
    public static function checkFilter(string $type, array $filters)
    {

        $filters_array_define = 'filters_array_'.$type;

        try {
            $filters_array_define = self::$$filters_array_define;
        } catch (Error | Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        $filters_array = [];

        foreach ($filters as $filter => $v) {
            if (!in_array($filter, $filters_array_define)) {
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
            $filters_array = ['filters' => $this->checkFilter(__FUNCTION__, $filters)];
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

    /**
     * @param string      $image
     * @param string|null $name
     * @param array|null  $cmd
     *
     * @return mixed
     * @throws Exception
     */
    public function create(string $image, string $name = null, array $cmd = null)
    {
        $url = self::$base_url.'/'.__FUNCTION__.'?'.http_build_query(['name' => $name]);

        $data = [
            'Image' => $image,
            'Cmd' => $cmd,
        ];

        $data = $this->setContainer($data);

        $request = json_encode($data);

        $json = self::$curl->post($url, $request, self::$header);

        $id = json_decode($json)->Id ?? null;

        if (null === $id) {

            throw new Exception(json_decode($json)->message, 500);
        }

        return $id;
    }

    /**
     * @param string      $id ID      or name of the container
     * @param string|null $detachKeys
     *
     * @return string
     * @throws Exception
     */
    public function start(string $id, string $detachKeys = null)
    {
        $url = self::$base_url.'/'.$id.'/start?'.http_build_query(['detachKeys' => $detachKeys]);

        $output = self::$curl->post($url);

        if ($output) {
            throw new Exception(json_decode($output)->message, 404);
        }

        return $id;
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

        return self::$curl->post($url);
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
     * @throws Exception
     */
    public function prune(array $filters = [])
    {
        $filters = [
            'filters' => self::checkFilter(__FUNCTION__, $filters),
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

    /**
     * @param array|null  $binds
     * @param string|null $networkMode
     * @param array|null  $portBindings
     * @param array|null  $restartPolicy
     * @param bool        $autoRemove
     * @param array|null  $mounts
     * @param array|null  $dns
     * @param array|null  $extraHosts
     *
     * @return $this
     */
    public function setHostConfig(array $binds = null,
                                  string $networkMode = null,
                                  array $portBindings = null,
                                  array $restartPolicy = null,
                                  bool $autoRemove = false,
                                  array $mounts = null,
                                  array $dns = null,
                                  array $extraHosts = null)
    {
        $this->hostConfig = array_filter([
            'Binds' => $binds,
            'NetworkMode' => $networkMode,
            'PortBindings' => $portBindings,
            'RestartPolicy' => $restartPolicy,
            'AutoRemove ' => $autoRemove,
            'Mounts' => $mounts,
            'Dns' => $dns,
            'ExtraHosts' => $extraHosts,
        ]);

        return $this;
    }

    private $networkingConfig;

    public function setNetworkingConfig(): void
    {
    }

    private function setContainer(array $data)
    {
        $array = get_class_vars(__CLASS__);

        $config = [];

        $remove = ['filters_array', 'header', 'curl'];

        foreach ($array as $k => $v) {
            if (in_array($k, $remove)) {
                unset($array[$k]);
            }
        }

        foreach ($array as $k => $v) {
            if (null == $v) {
                $property = ucfirst($k);
                $config[$property] = $this->$k;
            }
        }

        $data = array_filter(array_merge($data, $config));

        $this->inspect = $data;

        return $data;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     *
     * @return Container
     */
    public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomainname(): string
    {
        return $this->domainname;
    }

    /**
     * @param string $domainname
     *
     * @return Container
     */
    public function setDomainname(string $domainname)
    {
        $this->domainname = $domainname;

        return $this;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     *
     * @return Container
     */
    public function setUser(string $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAttachStdin(): bool
    {
        return $this->attachStdin;
    }

    /**
     * @param bool $attachStdin
     *
     * @return Container
     */
    public function setAttachStdin(bool $attachStdin)
    {
        $this->attachStdin = $attachStdin;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAttachStdout(): bool
    {
        return $this->attachStdout;
    }

    /**
     * @param bool $attachStdout
     *
     * @return Container
     */
    public function setAttachStdout(bool $attachStdout)
    {
        $this->attachStdout = $attachStdout;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAttachStderr(): bool
    {
        return $this->attachStderr;
    }

    /**
     * @param bool $attachStderr
     *
     * @return Container
     */
    public function setAttachStderr(bool $attachStderr)
    {
        $this->attachStderr = $attachStderr;

        return $this;
    }

    /**
     * @return array
     */
    public function getExposedPorts(): array
    {
        return $this->ExposedPorts;
    }

    /**
     * @param array $ExposedPorts
     *
     * @return Container
     */
    public function setExposedPorts(array $ExposedPorts)
    {
        $this->ExposedPorts = $ExposedPorts;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTty(): bool
    {
        return $this->tty;
    }

    /**
     * @param bool $tty
     *
     * @return Container
     */
    public function setTty(bool $tty)
    {
        $this->tty = $tty;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOpenStdin(): bool
    {
        return $this->openStdin;
    }

    /**
     * @param bool $openStdin
     *
     * @return Container
     */
    public function setOpenStdin(bool $openStdin)
    {
        $this->openStdin = $openStdin;

        return $this;
    }

    /**
     * @return bool
     */
    public function isStdinOnce(): bool
    {
        return $this->stdinOnce;
    }

    /**
     * @param bool $stdinOnce
     *
     * @return Container
     */
    public function setStdinOnce(bool $stdinOnce)
    {
        $this->stdinOnce = $stdinOnce;

        return $this;
    }

    /**
     * @return array
     */
    public function getEnv(): array
    {
        return $this->env;
    }

    /**
     * @param array $env
     *
     * @return Container
     */
    public function setEnv(array $env)
    {
        $envArray = [];

        foreach ($env as $k => $v) {
            $envArray[] = "$k=$v";
        }

        $this->env = $envArray;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHealthcheck()
    {
        return $this->healthcheck;
    }

    /**
     * @param mixed $healthcheck
     *
     * @return Container
     */
    public function setHealthcheck($healthcheck)
    {
        $this->healthcheck = $healthcheck;

        return $this;
    }

    /**
     * @return bool
     */
    public function isArgsEscaped(): bool
    {
        return $this->argsEscaped;
    }

    /**
     * @param bool $argsEscaped
     *
     * @return Container
     */
    public function setArgsEscaped(bool $argsEscaped)
    {
        $this->argsEscaped = $argsEscaped;

        return $this;
    }

    /**
     * @return array
     */
    public function getVolumes(): array
    {
        return $this->volumes;
    }

    /**
     * @param array $volumes
     *
     * @return Container
     */
    public function setVolumes(array $volumes)
    {
        $this->volumes = $volumes;

        return $this;
    }

    /**
     * @return string
     */
    public function getWorkingDir(): string
    {
        return $this->workingDir;
    }

    /**
     * @param string $workingDir
     *
     * @return Container
     */
    public function setWorkingDir(string $workingDir)
    {
        $this->workingDir = $workingDir;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getEntrypoint()
    {
        return $this->entrypoint;
    }

    /**
     * @param array|string $entrypoint
     *
     * @return Container
     */
    public function setEntrypoint($entrypoint)
    {
        $this->entrypoint = $entrypoint;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNetworkDisabled(): bool
    {
        return $this->networkDisabled;
    }

    /**
     * @param bool $networkDisabled
     *
     * @return Container
     */
    public function setNetworkDisabled(bool $networkDisabled)
    {
        $this->networkDisabled = $networkDisabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getMacAddress(): string
    {
        return $this->macAddress;
    }

    /**
     * @param string $macAddress
     *
     * @return Container
     */
    public function setMacAddress(string $macAddress)
    {
        $this->macAddress = $macAddress;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getOnBuild()
    {
        return $this->onBuild;
    }

    /**
     * @param array|string $onBuild
     *
     * @return Container
     */
    public function setOnBuild($onBuild)
    {
        $this->onBuild = $onBuild;

        return $this;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @param array $labels
     *
     * @return Container
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @return string
     */
    public function getStopSignal(): string
    {
        return $this->stopSignal;
    }

    /**
     * @param string $stopSignal
     *
     * @return Container
     */
    public function setStopSignal(string $stopSignal)
    {
        $this->stopSignal = $stopSignal;

        return $this;
    }

    /**
     * @return int
     */
    public function getStopTimeout(): int
    {
        return $this->stopTimeout;
    }

    /**
     * @param int $stopTimeout
     *
     * @return Container
     */
    public function setStopTimeout(int $stopTimeout)
    {
        $this->stopTimeout = $stopTimeout;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getShell()
    {
        return $this->shell;
    }

    /**
     * @param array|string $shell
     *
     * @return Container
     */
    public function setShell($shell)
    {
        $this->shell = $shell;

        return $this;
    }
}
