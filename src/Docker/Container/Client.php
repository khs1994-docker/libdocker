<?php

/** @noinspection PhpUnusedPrivateFieldInspection */

declare(strict_types=1);

namespace Docker\Container;

use Curl\Curl;
use Error;
use Exception;

/**
 * Container.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Container
 */
class Client
{
    const TYPE = 'containers';

    /**
     * @var Curl
     */
    private static $curl;

    private static $base_url;

    private static $header = ['content-type' => 'application/json'];

    /**
     * @var array
     *
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
     *
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

    private $cmd;

    private $healthcheck;

    /**
     * @var bool Windows Only
     */
    private $argsEscaped = false;

    /**
     * @var string
     */
    private $image;

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

    private $shell = null;

    private $hostConfig = [];

    private $networkingConfig;

    /**
     * @var string
     */
    private $container_name;
    /**
     * @var string
     */
    private $container_id;

    /**
     * @var array
     */
    private $raw;
    /**
     * @var array
     */
    private $create_raw;

    /**
     * @var int
     */
    private $cpuShares;
    /**
     * @var int
     */
    private $memory;
    /**
     * @var string
     */
    private $CgroupParent;
    /**
     * @var int 0-1000
     */
    private $bikioWeight;
    /**
     * @var array
     */
    private $bikioWeightDevice;
    /**
     * @var array
     */
    private $bikioDeviceReadBps;
    /**
     * @var array
     */
    private $bikioDeviceWriteBps;
    /**
     * @var array
     */
    private $bikioDeviceReadIOps;
    /**
     * @var array
     */
    private $bikioDeviceWriteIOps;
    /**
     * @var int
     */
    private $cpuPeriod;
    /**
     * @var int
     */
    private $cpuQuota;
    /**
     * @var int
     */
    private $cpuRealtimePeriod;
    /**
     * @var int
     */
    private $cpuRealtimeRuntime;
    /**
     * @var string
     */
    private $cpusetCpus;
    /**
     * @var string
     */
    private $cpusetMems;
    /**
     * @var array
     */
    private $devices;
    /**
     * @var array
     */
    private $deviceCgroupRules;
    /**
     * @var int
     */
    private $diskQuote;
    /**
     * @var int
     */
    private $kernelMemory;
    /**
     * @var int
     */
    private $memoryReservation;
    /**
     * @var int
     */
    private $memorySwap;
    /**
     * @var int 0-100
     */
    private $memorySwappiness;
    /**
     * @var int
     */
    private $NanoCPUs;
    /**
     * @var bool
     */
    private $oomKillDisable = true;
    /**
     * @var bool
     */
    private $init = true;
    /**
     * @var int
     */
    private $pidsLimit;
    /**
     * @var array
     */
    private $ulimits;
    /**
     * @var int
     */
    private $cpuCount;
    /**
     * @var int
     */
    private $cpuPercent;
    /**
     * @var int
     */
    private $IOMaximumIOps;
    /**
     * @var int
     */
    private $IOMaximumBandWidth;
    /**
     * @var array
     */
    private $binds;
    /**
     * @var string
     */
    private $containerIDFile;
    /**
     * @var array
     */
    private $logConfig;
    /**
     * @var string
     */
    private $networkMode;
    /**
     * @var array
     */
    private $PortBindings;
    /**
     * @var array
     */
    private $restartPolicy;
    /**
     * @var bool
     */
    private $autoRemove;
    /**
     * @var string
     */
    private $volumeDriver;
    /**
     * @var array
     */
    private $volumesFrom;
    /**
     * @var array
     */
    private $mounts;
    /**
     * @var array
     */
    private $capAdd;
    /**
     * @var array
     */
    private $capDrop;
    /**
     * @var array
     */
    private $dns;
    /**
     * @var array
     */
    private $dnsOptions;
    /**
     * @var array
     */
    private $dnsSearch;
    /**
     * @var array
     */
    private $extraHosts;
    /**
     * @var array
     */
    private $groupAdd;
    /**
     * @var string
     */
    private $ipcMode;
    /**
     * @var string
     */
    private $Cgroup;
    /**
     * @var int
     */
    private $oomScoreAdj;
    /**
     * @var string
     */
    private $pidMode;
    /**
     * @var bool
     */
    private $privileged;
    /**
     * @var bool
     */
    private $publishAllPorts;
    /**
     * @var bool
     */
    private $readonlyRootfs;
    /**
     * @var array
     */
    private $securityOpt;
    /**
     * @var array
     */
    private $StorageOpt;
    /**
     * @var array
     */
    private $tmpfs;
    /**
     * @var string
     */
    private $UTSMode;
    /**
     * @var string
     */
    private $usernsMode;
    /**
     * @var int >=0
     */
    private $shmSize;
    /**
     * @var array
     */
    private $sysctls;
    /**
     * @var string
     */
    private $runtime;
    /**
     * @var array Windows only
     */
    private $consoleSize;
    /**
     * @var string
     */
    private $isolation;
    /**
     * @var array
     */
    private $network_aliases;

    /**
     * @return mixed
     */
    public function getCmd()
    {
        return $this->cmd;
    }

    /**
     * @param mixed $cmd
     */
    public function setCmd($cmd): void
    {
        $this->cmd = $cmd;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getContainerName()
    {
        return $this->container_name;
    }

    /**
     * @param mixed $container_name
     */
    public function setContainerName($container_name): void
    {
        $this->container_name = $container_name;
    }

    /**
     * @param array|null  $binds         ["$unique_id:$work_dir", 'tmp:/tmp']
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

    public function setNetworkingConfig(): void
    {
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
     * @return Client
     */
    public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;

        $this->raw = array_merge($this->raw, ['Hostname' => $hostname]);

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
     * @return Client
     */
    public function setDomainname(string $domainname)
    {
        $this->domainname = $domainname;

        $this->raw = array_merge($this->raw, ['Domainname' => $domainname]);

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
     * @return Client
     */
    public function setUser(string $user)
    {
        $this->user = $user;

        $this->raw = array_merge($this->raw, ['User' => $user]);

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
     * @return Client
     */
    public function setAttachStdin(bool $attachStdin = false)
    {
        $this->attachStdin = $attachStdin;

        $this->raw = array_merge($this->raw, ['AttachStdin' => $attachStdin]);

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
     * @return Client
     */
    public function setAttachStdout(bool $attachStdout = false)
    {
        $this->attachStdout = $attachStdout;

        $this->raw = array_merge($this->raw, ['AttachStdout' => $attachStdout]);

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
     * @return Client
     */
    public function setAttachStderr(bool $attachStderr = false)
    {
        $this->attachStderr = $attachStderr;

        $this->raw = array_merge($this->raw, ['AttachStderr' => $attachStderr]);

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
     * @param array $exposedPorts {"<port>/<tcp|udp|sctp>": {}} ["22/tcp":[]]
     *
     * @return Client
     */
    public function setExposedPorts(array $exposedPorts)
    {
        $this->ExposedPorts = $exposedPorts;

        $this->raw = array_merge($this->raw, ['ExposedPorts' => $exposedPorts]);

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
     * @return Client
     */
    public function setTty(bool $tty = false)
    {
        $this->tty = $tty;

        $this->raw = array_merge($this->raw, ['Tty' => $tty]);

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
     * @return Client
     */
    public function setOpenStdin(bool $openStdin = false)
    {
        $this->openStdin = $openStdin;

        $this->raw = array_merge($this->raw, ['OpenStdin' => $openStdin]);

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
     * @return Client
     */
    public function setStdinOnce(bool $stdinOnce = false)
    {
        $this->stdinOnce = $stdinOnce;

        $this->raw = array_merge($this->raw, ['StdinOnce' => $stdinOnce]);

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
     * @param array|null $env ['env=value']
     *
     * @return Client
     */
    public function setEnv(array $env)
    {
        $this->env = $env;

        $this->raw = array_merge($this->raw, ['Env' => $env]);

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
     * @param array $test
     * @param int   $interval
     * @param int   $timeout
     * @param int   $retries
     * @param int   $startPeriod
     *
     * @return Client
     */
    public function setHealthcheck(array $test = [], int $interval = 0, int $timeout = 0, int $retries = 0, int $startPeriod = 0)
    {
        $this->healthcheck = [
            'Test' => $test,
            'Interval' => $interval,
            'Timeout' => $timeout,
            'Retries' => $retries,
            'StartPeriod' => $startPeriod,
        ];

        $this->raw = array_merge($this->raw, ['Healthcheck' => $this->healthcheck]);

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
     * @return Client
     */
    public function setArgsEscaped(bool $argsEscaped = false)
    {
        $this->argsEscaped = $argsEscaped;

        $this->raw = array_merge($this->raw, ['ArgsEscaped' => $argsEscaped]);

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
     * @param array $volumes [ "path" : [] ]
     *
     * @return Client
     */
    public function setVolumes(array $volumes)
    {
        $this->volumes = $volumes;

        $this->raw = array_merge($this->raw, ['Volumes' => $volumes]);

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
     * @return Client
     */
    public function setWorkingDir(string $workingDir)
    {
        $this->workingDir = $workingDir;

        $this->raw = array_merge($this->raw, ['WorkingDir' => $workingDir]);

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
     * @param array $entrypoint ['/bin/sh', '-c']
     *
     * @return Client
     */
    public function setEntrypoint(array $entrypoint)
    {
        $this->entrypoint = $entrypoint;

        $this->raw = array_merge($this->raw, ['Entrypoint' => $entrypoint]);

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
     * @return Client
     */
    public function setNetworkDisabled(bool $networkDisabled = true)
    {
        $this->networkDisabled = $networkDisabled;

        $this->raw = array_merge($this->raw, ['NetworkDisabled' => $networkDisabled]);

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
     * @return Client
     */
    public function setMacAddress(string $macAddress)
    {
        $this->macAddress = $macAddress;

        $this->raw = array_merge($this->raw, ['MacAddress' => $macAddress]);

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
     * @return Client
     */
    public function setOnBuild($onBuild)
    {
        $this->onBuild = $onBuild;

        $this->raw = array_merge($this->raw, ['OnBuild' => $onBuild]);

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
     * @param array|null $labels
     *
     * @return Client
     */
    public function setLabels(?array $labels = ['com.khs1994.docker' => 'value'])
    {
        $this->labels = $labels;

        $this->raw = array_merge($this->raw, ['Labels' => $labels]);

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
     * @return Client
     */
    public function setStopSignal(string $stopSignal = 'SIGTERM')
    {
        $this->stopSignal = $stopSignal;

        $this->raw = array_merge($this->raw, ['StopSignal' => $stopSignal]);

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
     * @return Client
     */
    public function setStopTimeout(int $stopTimeout)
    {
        $this->stopTimeout = $stopTimeout;

        $this->raw = array_merge($this->raw, ['StopTimeout' => $stopTimeout]);

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
     * @return Client
     */
    public function setShell($shell)
    {
        $this->shell = $shell;

        $this->raw = array_merge($this->raw, ['Shell' => $shell]);

        return $this;
    }

    /**
     * @param int $cpuShares
     *
     * @return Client
     */
    public function setCpuShares(int $cpuShares)
    {
        $this->cpuShares = $cpuShares;

        return $this;
    }

    /**
     * @param int $memory
     *
     * @return Client
     */
    public function setMemory(int $memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * @param string $CgroupParent
     *
     * @return Client
     */
    public function setCgroupParent(string $CgroupParent)
    {
        $this->CgroupParent = $CgroupParent;

        return $this;
    }

    /**
     * @param int $bikioWeight
     *
     * @return Client
     */
    public function setBikioWeight(int $bikioWeight)
    {
        $this->bikioWeight = $bikioWeight;

        return $this;
    }

    /**
     * @param array $bikioWeightDevice
     *
     * @return Client
     */
    public function setBikioWeightDevice(array $bikioWeightDevice)
    {
        $this->bikioWeightDevice = $bikioWeightDevice;

        return $this;
    }

    /**
     * @param array $bikioDeviceReadBps
     *
     * @return Client
     */
    public function setBikioDeviceReadBps(array $bikioDeviceReadBps)
    {
        $this->bikioDeviceReadBps = $bikioDeviceReadBps;

        return $this;
    }

    /**
     * @param array $bikioDeviceWriteBps
     *
     * @return Client
     */
    public function setBikioDeviceWriteBps(array $bikioDeviceWriteBps)
    {
        $this->bikioDeviceWriteBps = $bikioDeviceWriteBps;

        return $this;
    }

    /**
     * @param array $bikioDeviceReadIOps
     *
     * @return Client
     */
    public function setBikioDeviceReadIOps(array $bikioDeviceReadIOps)
    {
        $this->bikioDeviceReadIOps = $bikioDeviceReadIOps;

        return $this;
    }

    /**
     * @param array $bikioDeviceWriteIOps
     *
     * @return Client
     */
    public function setBikioDeviceWriteIOps(array $bikioDeviceWriteIOps)
    {
        $this->bikioDeviceWriteIOps = $bikioDeviceWriteIOps;

        return $this;
    }

    /**
     * @param int $cpuPeriod
     *
     * @return Client
     */
    public function setCpuPeriod(int $cpuPeriod)
    {
        $this->cpuPeriod = $cpuPeriod;

        return $this;
    }

    /**
     * @param int $cpuQuota
     *
     * @return Client
     */
    public function setCpuQuota(int $cpuQuota)
    {
        $this->cpuQuota = $cpuQuota;

        return $this;
    }

    /**
     * @param int $cpuRealtimePeriod
     *
     * @return Client
     */
    public function setCpuRealtimePeriod(int $cpuRealtimePeriod)
    {
        $this->cpuRealtimePeriod = $cpuRealtimePeriod;

        return $this;
    }

    /**
     * @param int $cpuRealtimeRuntime
     *
     * @return Client
     */
    public function setCpuRealtimeRuntime(int $cpuRealtimeRuntime)
    {
        $this->cpuRealtimeRuntime = $cpuRealtimeRuntime;

        return $this;
    }

    /**
     * @param string $cpusetCpus
     *
     * @return Client
     */
    public function setCpusetCpus(string $cpusetCpus)
    {
        $this->cpusetCpus = $cpusetCpus;

        return $this;
    }

    /**
     * @param string $cpusetMems
     *
     * @return Client
     */
    public function setCpusetMems(string $cpusetMems)
    {
        $this->cpusetMems = $cpusetMems;

        return $this;
    }

    /**
     * @param array $devices
     *
     * @return Client
     */
    public function setDevices(array $devices)
    {
        $this->devices = $devices;

        return $this;
    }

    /**
     * @param array $deviceCgroupRules
     *
     * @return Client
     */
    public function setDeviceCgroupRules(array $deviceCgroupRules)
    {
        $this->deviceCgroupRules = $deviceCgroupRules;

        return $this;
    }

    /**
     * @param int $diskQuote
     *
     * @return Client
     */
    public function setDiskQuote(int $diskQuote)
    {
        $this->diskQuote = $diskQuote;

        return $this;
    }

    /**
     * @param int $kernelMemory
     *
     * @return Client
     */
    public function setKernelMemory(int $kernelMemory)
    {
        $this->kernelMemory = $kernelMemory;

        return $this;
    }

    /**
     * @param int $memoryReservation
     *
     * @return Client
     */
    public function setMemoryReservation(int $memoryReservation)
    {
        $this->memoryReservation = $memoryReservation;

        return $this;
    }

    /**
     * @param int $memorySwap
     *
     * @return Client
     */
    public function setMemorySwap(int $memorySwap)
    {
        $this->memorySwap = $memorySwap;

        return $this;
    }

    /**
     * @param int $memorySwappiness
     *
     * @return Client
     */
    public function setMemorySwappiness(int $memorySwappiness)
    {
        $this->memorySwappiness = $memorySwappiness;

        return $this;
    }

    /**
     * @param int $NanoCPUs
     *
     * @return Client
     */
    public function setNanoCPUs(int $NanoCPUs)
    {
        $this->NanoCPUs = $NanoCPUs;

        return $this;
    }

    /**
     * @param bool $oomKillDisable
     *
     * @return Client
     */
    public function setOomKillDisable(bool $oomKillDisable)
    {
        $this->oomKillDisable = $oomKillDisable;

        return $this;
    }

    /**
     * @param bool $init
     *
     * @return Client
     */
    public function setInit(bool $init)
    {
        $this->init = $init;

        return $this;
    }

    /**
     * @param int $pidsLimit
     *
     * @return Client
     */
    public function setPidsLimit(int $pidsLimit)
    {
        $this->pidsLimit = $pidsLimit;

        return $this;
    }

    /**
     * @param array $ulimits
     *
     * @return Client
     */
    public function setUlimits(array $ulimits)
    {
        $this->ulimits = $ulimits;

        return $this;
    }

    /**
     * @param int $cpuCount
     *
     * @return Client
     */
    public function setCpuCount(int $cpuCount)
    {
        $this->cpuCount = $cpuCount;

        return $this;
    }

    /**
     * @param int $cpuPercent
     *
     * @return Client
     */
    public function setCpuPercent(int $cpuPercent)
    {
        $this->cpuPercent = $cpuPercent;

        return $this;
    }

    /**
     * @param int $IOMaximumIOps
     *
     * @return Client
     */
    public function setIOMaximumIOps(int $IOMaximumIOps)
    {
        $this->IOMaximumIOps = $IOMaximumIOps;

        return $this;
    }

    /**
     * @param int $IOMaximumBandWidth
     *
     * @return Client
     */
    public function setIOMaximumBandWidth(int $IOMaximumBandWidth)
    {
        $this->IOMaximumBandWidth = $IOMaximumBandWidth;

        return $this;
    }

    /**
     * @param array $binds
     *
     * @return Client
     */
    public function setBinds(array $binds)
    {
        $this->binds = $binds;

        return $this;
    }

    /**
     * @param string $containerIDFile
     *
     * @return Client
     */
    public function setContainerIDFile(string $containerIDFile)
    {
        $this->containerIDFile = $containerIDFile;

        return $this;
    }

    /**
     * @param array $logConfig
     *
     * @return Client
     */
    public function setLogConfig(array $logConfig)
    {
        $this->logConfig = $logConfig;

        return $this;
    }

    /**
     * @param string $networkMode
     *
     * @return Client
     */
    public function setNetworkMode(string $networkMode)
    {
        $this->networkMode = $networkMode;

        return $this;
    }

    /**
     * @param array $PortBindings
     *
     * @return Client
     */
    public function setPortBindings(array $PortBindings)
    {
        $this->PortBindings = $PortBindings;

        return $this;
    }

    /**
     * @param array $restartPolicy
     *
     * @return Client
     */
    public function setRestartPolicy(array $restartPolicy)
    {
        $this->restartPolicy = $restartPolicy;

        return $this;
    }

    /**
     * @param bool $autoRemove
     *
     * @return Client
     */
    public function setAutoRemove(bool $autoRemove)
    {
        $this->autoRemove = $autoRemove;

        return $this;
    }

    /**
     * @param string $volumeDriver
     *
     * @return Client
     */
    public function setVolumeDriver(string $volumeDriver)
    {
        $this->volumeDriver = $volumeDriver;

        return $this;
    }

    /**
     * @param array $volumesFrom
     *
     * @return Client
     */
    public function setVolumesFrom(array $volumesFrom)
    {
        $this->volumesFrom = $volumesFrom;

        return $this;
    }

    /**
     * @param array $mounts
     *
     * @return Client
     */
    public function setMounts(array $mounts)
    {
        $this->mounts = $mounts;

        return $this;
    }

    /**
     * @param array $capAdd
     *
     * @return Client
     */
    public function setCapAdd(array $capAdd)
    {
        $this->capAdd = $capAdd;

        return $this;
    }

    /**
     * @param array $capDrop
     *
     * @return Client
     */
    public function setCapDrop(array $capDrop)
    {
        $this->capDrop = $capDrop;

        return $this;
    }

    /**
     * @param array $dns
     *
     * @return Client
     */
    public function setDns(array $dns)
    {
        $this->dns = $dns;

        return $this;
    }

    /**
     * @param array $dnsOptions
     *
     * @return Client
     */
    public function setDnsOptions(array $dnsOptions)
    {
        $this->dnsOptions = $dnsOptions;

        return $this;
    }

    /**
     * @param array $dnsSearch
     *
     * @return Client
     */
    public function setDnsSearch(array $dnsSearch)
    {
        $this->dnsSearch = $dnsSearch;

        return $this;
    }

    /**
     * @param array $extraHosts
     *
     * @return Client
     */
    public function setExtraHosts(array $extraHosts)
    {
        $this->extraHosts = $extraHosts;

        return $this;
    }

    /**
     * @param array $groupAdd
     *
     * @return Client
     */
    public function setGroupAdd(array $groupAdd)
    {
        $this->groupAdd = $groupAdd;

        return $this;
    }

    /**
     * @param string $ipcMode
     *
     * @return Client
     */
    public function setIpcMode(string $ipcMode)
    {
        $this->ipcMode = $ipcMode;

        return $this;
    }

    /**
     * @param string $Cgroup
     *
     * @return Client
     */
    public function setCgroup(string $Cgroup)
    {
        $this->Cgroup = $Cgroup;

        return $this;
    }

    /**
     * @param int $oomScoreAdj
     *
     * @return Client
     */
    public function setOomScoreAdj(int $oomScoreAdj)
    {
        $this->oomScoreAdj = $oomScoreAdj;

        return $this;
    }

    /**
     * @param string $pidMode
     *
     * @return Client
     */
    public function setPidMode(string $pidMode)
    {
        $this->pidMode = $pidMode;

        return $this;
    }

    /**
     * @param bool $privileged
     *
     * @return Client
     */
    public function setPrivileged(bool $privileged)
    {
        $this->privileged = $privileged;

        return $this;
    }

    /**
     * @param bool $publishAllPorts
     *
     * @return Client
     */
    public function setPublishAllPorts(bool $publishAllPorts)
    {
        $this->publishAllPorts = $publishAllPorts;

        return $this;
    }

    /**
     * @param bool $readonlyRootfs
     *
     * @return Client
     */
    public function setReadonlyRootfs(bool $readonlyRootfs)
    {
        $this->readonlyRootfs = $readonlyRootfs;

        return $this;
    }

    /**
     * @param array $securityOpt
     *
     * @return Client
     */
    public function setSecurityOpt(array $securityOpt)
    {
        $this->securityOpt = $securityOpt;

        return $this;
    }

    /**
     * @param array $StorageOpt
     *
     * @return Client
     */
    public function setStorageOpt(array $StorageOpt)
    {
        $this->StorageOpt = $StorageOpt;

        return $this;
    }

    /**
     * @param array $tmpfs
     *
     * @return Client
     */
    public function setTmpfs(array $tmpfs)
    {
        $this->tmpfs = $tmpfs;

        return $this;
    }

    /**
     * @param string $UTSMode
     *
     * @return Client
     */
    public function setUTSMode(string $UTSMode)
    {
        $this->UTSMode = $UTSMode;

        return $this;
    }

    /**
     * @param string $usernsMode
     *
     * @return Client
     */
    public function setUsernsMode(string $usernsMode)
    {
        $this->usernsMode = $usernsMode;

        return $this;
    }

    /**
     * @param int $shmSize
     *
     * @return Client
     */
    public function setShmSize(int $shmSize)
    {
        $this->shmSize = $shmSize;

        return $this;
    }

    /**
     * @param array $sysctls
     *
     * @return Client
     */
    public function setSysctls(array $sysctls)
    {
        $this->sysctls = $sysctls;

        return $this;
    }

    /**
     * @param string $runtime
     *
     * @return Client
     */
    public function setRuntime(string $runtime)
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * @param array $consoleSize
     *
     * @return Client
     */
    public function setConsoleSize(array $consoleSize)
    {
        $this->consoleSize = $consoleSize;

        return $this;
    }

    /**
     * @param string $isolation
     *
     * @return Client
     */
    public function setIsolation(string $isolation)
    {
        $this->isolation = $isolation;

        return $this;
    }

    /**
     * @param array $network_aliases
     *
     * @return Client
     */
    public function setNetworkAliases(array $network_aliases)
    {
        $this->network_aliases = $network_aliases;

        return $this;
    }

    /**
     * @return string
     */
    public function getContainerId(): string
    {
        return $this->container_id;
    }

    /**
     * @param string $container_id
     */
    public function setContainerId(string $container_id): void
    {
        $this->container_id = $container_id;
    }

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
            if (!in_array($filter, $filters_array_define, true)) {
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
     * ancestor=(<image-name>[:<tag>], <image id>, or <image@digest>)
     * before=(<container id> or <container name>)
     * expose=(<port>[/<proto>]|<startport-endport>/[<proto>])
     * exited=<int> containers with exit code of <int>
     * health=(starting|healthy|unhealthy|none)
     * id=<ID> a container's ID
     * isolation=(default|process|hyperv) (Windows daemon only)
     * is-task=(true|false)
     * label=key or label="key=value" of a container label
     * name=<name> a container's name
     * network=(<network id> or <network name>)
     * publish=(<port>[/<proto>]|<startport-endport>/[<proto>])
     * since=(<container id> or <container name>)
     * status=(created|restarting|running|removing|paused|exited|dead)
     * volume=(<volume name> or <mount point destination>)
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
     * @return mixed
     *
     * @throws Exception
     */
    public function create()
    {
        $url = self::$base_url.'/'.__FUNCTION__.'?'.http_build_query(['name' => $this->container_name]);

        $request = json_encode($this->raw);

        $json = self::$curl->post($url, $request, self::$header);

        $id = json_decode($json)->Id ?? null;

        if (null === $id) {
            throw new Exception(json_decode($json)->message, self::$curl->getCode());
        }

        $this->container_id = $id;

        // clean raw

        $this->create_raw = $this->raw;

        $this->raw = null;

        return $id;
    }

    public function getCreateJson()
    {
        return $this->create_raw;
    }

    /**
     * Inspect a container.
     *
     * Return low-level information about a container.
     *
     * @param string $id
     * @param bool   $size
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function inspect(string $id, bool $size = false)
    {
        $url = self::$base_url.'/'.$id.'/json?'.http_build_query(['size' => $size]);

        return self::$curl->get($url);
    }

    /**
     * List processes running inside a container.
     *
     * On Unix systems, this is done by running the ps command. This endpoint is not supported on Windows.
     *
     * @param string|null $id
     * @param string      $ps_args
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function top(?string $id, string $ps_args = '-ef')
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/'.__FUNCTION__.'?'.http_build_query(['ps_args' => $ps_args]);

        return self::$curl->get($url);
    }

    /**
     * Get container logs.
     *
     * Get stdout and stderr logs from a container.
     *
     * Note: This endpoint works only for containers with the json-file or journald logging driver.
     *
     * @param string|null $id
     * @param bool        $follow
     * @param bool        $stdout
     * @param bool        $stderr
     * @param int         $since
     * @param int         $until
     * @param bool        $timestamps
     * @param string      $tail
     *
     * @return mixed
     *
     * @throws Exception
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

        $url = self::$base_url.'/'.$id ?? $this->container_id.'/'.__FUNCTION__.'?'.http_build_query($data);

        return self::$curl->get($url);
    }

    /**
     * Get changes on a container’s filesystem.
     *
     * Returns which files in a container's filesystem have been added, deleted, or modified. The Kind of modification
     * can be one of:
     *
     * 0: Modified
     * 1: Added
     * 2: Deleted
     *
     * @param string|null $id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function changes(?string $id)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/'.__FUNCTION__;

        return self::$curl->get($url);
    }

    /**
     * Export a container.
     *
     * Export the contents of a container as a tarball.
     *
     * @param string|null $id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function export(string $id)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/'.__FUNCTION__;

        return self::$curl->get($url);
    }

    /**
     * Get container stats based on resource usage.
     *
     * @param string|null $id
     * @param bool        $stream Stream the output. If false, the stats will be output once and then it will
     *                            disconnect.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function stats(?string $id, bool $stream = false)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/stats?'.http_build_query(['stream' => $stream]);

        return self::$curl->get($url);
    }

    /**
     * Resize a container TTY.
     *
     * Resize the TTY for a container. You must restart the container for the resize to take effect.
     *
     * @param string|null $id
     * @param int         $height Height of the tty session in characters
     * @param int         $width  Width of the tty session in characters
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function resize(?string $id, int $height, int $width)
    {
        $data = [
            'height' => $height,
            'width' => $width,
        ];

        $url = self::$base_url.'/'.$id ?? $this->container_id.'/resize?'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id         ID or name of the container
     * @param string|null $detachKeys Override the key sequence for detaching a container.
     *                                Format is a single character `[a-Z]`
     *                                or `ctrl-<value>` where <value> is one of: `a-z`,`@`,`^`,`[`,`,` or `_`.
     *
     * @return string
     *
     * @throws Exception
     */
    public function start(?string $id, string $detachKeys = null)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/start?'.http_build_query(['detachKeys' => $detachKeys]);

        $output = self::$curl->post($url);

        if ($output) {
            throw new Exception(json_decode($output)->message, 404);
        }

        return $id;
    }

    /**
     * @param string|null $id
     * @param int         $waitTime
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function stop(?string $id, int $waitTime = 0)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/stop?'.http_build_query(['t' => $waitTime]);

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id
     * @param int         $waitTime
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function restart(?string $id, int $waitTime = 0)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/restart?'.http_persistent_handles_clean(['t' => $waitTime]);

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id
     * @param string      $signal
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function kill(?string $id, string $signal = 'SIGKILL')
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/kill?'.http_build_query(['signal' => $signal]);

        return self::$curl->post($url);
    }

    /**
     * TODO.
     *
     * @param string|null $id
     * @param array       $request_body
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function update(?string $id, array $request_body = [])
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/update';
        $request = json_encode($request_body);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * @param string|null $id
     * @param string      $name
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function rename(?string $id, string $name)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/rename?'.http_build_query(['name' => $name]);

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function pause(?string $id)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/pause';

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function unpause(?string $id)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/unpause';

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id
     * @param string|null $detachKeys
     * @param bool        $logs
     * @param bool        $stream
     * @param bool        $stdin
     * @param bool        $stdout
     * @param bool        $stderr
     *
     * @return mixed
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.35/#operation/ContainerAttach
     */
    public function attach(?string $id,
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

        $url = self::$base_url.'/'.$id ?? $this->container_id.'/attach?'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * Attach to a container via a websocket.
     *
     * @param null|string $id
     * @param string      $detachKeys
     * @param bool        $logs
     * @param bool        $stream
     * @param bool        $stdin
     * @param bool        $stdout
     * @param bool        $stderr
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function attachViaWebSocket(?string $id,
                                       string $detachKeys,
                                       bool $logs = false,
                                       bool $stream = false,
                                       bool $stdin = false,
                                       bool $stdout = false,
                                       bool $stderr = false)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/attach/ws?'.http_build_query([
                    'detachKeys' => $detachKeys,
                    'logs' => $logs,
                    'stream' => $stream,
                    'stdin' => $stdin,
                    'stdout' => $stdout,
                    'stderr' => $stderr,
                ]
            );

        return self::$curl->get($url);
    }

    /**
     * Wait for a container.
     *
     * Block until a container stops, then returns the exit code.
     *
     * @param string|null $id
     * @param string      $condition
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function wait(?string $id, string $condition = 'not-running')
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/wait?'.http_build_query(['condition' => $condition]);

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id
     * @param bool        $v
     * @param bool        $force
     * @param bool        $link
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function remove(?string $id, bool $v = false, bool $force = false, bool $link = false)
    {
        $data = [
            'v' => $v,
            'force' => $force,
            'link' => $link,
        ];
        $url = self::$base_url.'/'.$id ?? $this->container_id.'?'.http_build_query($data);

        return self::$curl->delete($url);
    }

    /**
     * Get information about files in a container.
     *
     * A response header `X-Docker-Container-Path-Stat` is return containing a base64 - encoded JSON object with some
     * filesystem header information about the path.
     *
     * @param null|string $id
     * @param string      $path
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getFileInfo(?string $id, string $path)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/archive?'.http_build_query([
                'path' => $path,
            ]);

        self::$curl->get($url);

        return self::$curl->getResponseHeaders();
    }

    /**
     * Get an archive of a filesystem resource in a container.
     *
     * @param string $id
     * @param string $path
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function archive(?string $id, string $path)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/archive?'.http_build_query(['path' => $path]);

        return self::$curl->get($url);
    }

    /**
     * Extract an archive of files or folders to a directory in a container.
     *
     * @param string|null $id
     * @param string      $path
     * @param bool        $noOverwriteDirNonDir
     * @param string      $request
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function extract(?string $id, string $path, bool $noOverwriteDirNonDir, string $request)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/archive?'.http_build_query([
                'path' => $path,
                'noOverwriteDirNonDir' => $noOverwriteDirNonDir,
            ]);

        return self::$curl->put($url, $request);
    }

    /**
     * @param array $filters
     *
     * Available filters:
     *
     * `until=<timestamp>` Prune containers created before this timestamp. The <timestamp> can be Unix timestamps, date
     * formatted timestamps, or Go duration strings (e.g. 10m, 1h30m) computed relative to the daemon machine’s time.
     *
     * label (label=<key>, label=<key>=<value>, label!=<key>, or label!=<key>=<value>) Prune containers with (or
     * without, in case label!=... is used) the specified labels.
     *
     * @return mixed
     *
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
     * @param string|null $id
     * @param array|null  $cmd
     * @param array|null  $env
     * @param string      $user
     * @param string      $workingDir
     * @param array       $other
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function createExec(?string $id,
                               array $cmd = null,
                               array $env = null,
                               string $user,
                               string $workingDir,
                               array $other)
    {
        $url = self::$base_url.'/'.$id ?? $this->container_id.'/exec';

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
     * @param string|null $id
     * @param bool        $detach
     * @param bool        $tty
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function startExec(?string $id, bool $detach = false, bool $tty = false)
    {
        $url = self::$base_url.'/exec'.$id ?? $this->container_id.'/start';

        $data = [
            'Detach' => $detach,
            'Tty' => $tty,
        ];

        $request = json_encode($data);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * @param string|null $id
     * @param int         $height
     * @param int         $width
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function resizeExec(?string $id, int $height, int $width)
    {
        $data = [
            'h' => $height,
            'w' => $width,
        ];

        $url = self::$base_url.'/exec'.$id ?? $this->container_id.'/resize'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function inspectExec(string $id)
    {
        $url = self::$base_url.'/exec'.$id.'/json';

        return self::$curl->get($url);
    }
}
