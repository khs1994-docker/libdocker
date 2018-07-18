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

    private $networkingConfig = [];

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
    private $raw = [];

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
    private $blkioWeight;

    /**
     * @var array
     */
    private $blkioWeightDevice;

    /**
     * @var array
     */
    private $blkioDeviceReadBps;

    /**
     * @var array
     */
    private $blkioDeviceWriteBps;

    /**
     * @var array
     */
    private $blkioDeviceReadIOps;

    /**
     * @var array
     */
    private $blkioDeviceWriteIOps;

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
     * @param array $cmd [ "nginx", "-g", "daemon off;"]
     *
     * @return Client
     */
    public function setCmd(array $cmd)
    {
        $this->cmd = $cmd;

        $this->raw = array_merge($this->raw, ['Cmd' => $cmd]);

        return $this;
    }

    /**
     * @param mixed $image
     *
     * @return Client
     */
    public function setImage($image)
    {
        $this->image = $image;

        $this->raw = array_merge($this->raw, ['Image' => $image]);

        return $this;
    }

    /**
     * @param string $container_name
     *
     * @return Client
     */
    public function setContainerName(string $container_name)
    {
        $this->container_name = $container_name;

        return $this;
    }

    /**
     * @param array $networkingConfig
     *
     * @return Client
     */
    public function setNetworkingConfig(array $networkingConfig)
    {
        $this->networkingConfig = $networkingConfig;

        $this->raw = array_merge($this->raw, ['NetworkingConfig' => $networkingConfig]);

        return $this;
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
     * @param array $exposedPorts ["22/<tcp|udp|sctp>":[]]
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
     * @param array|null $env ['env=value']
     *
     * @return Client
     */
    public function setEnv(array $env = ['k=v'])
    {
        $this->env = $env;

        $this->raw = array_merge($this->raw, ['Env' => $env]);

        return $this;
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
     * @param array|null $labels ['com.khs1994.docker' => 'value']
     *
     * @return Client
     */
    public function setLabels(array $labels = ['k' => 'v'])
    {
        $this->labels = $labels;

        $this->raw = array_merge($this->raw, ['Labels' => $labels]);

        return $this;
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

        $this->hostConfig = array_merge($this->hostConfig, ['CpuShares' => $cpuShares]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Memory' => $memory]);

        return $this;
    }

    /**
     * @param string $cgroupParent
     *
     * @return Client
     */
    public function setCgroupParent(string $cgroupParent)
    {
        $this->CgroupParent = $cgroupParent;

        $this->hostConfig = array_merge($this->hostConfig, ['CgroupParent' => $cgroupParent]);

        return $this;
    }

    /**
     * @param int $blkioWeight
     *
     * @return Client
     */
    public function setBlkioWeight(int $blkioWeight)
    {
        $this->blkioWeight = $blkioWeight;

        $this->hostConfig = array_merge($this->hostConfig, ['BlkioWeight' => $blkioWeight]);

        return $this;
    }

    /**
     * @param array $blkioWeightDevice
     *
     * @return Client
     */
    public function setBlkioWeightDevice(array $blkioWeightDevice)
    {
        $this->blkioWeightDevice = $blkioWeightDevice;

        $this->hostConfig = array_merge($this->hostConfig, ['BlkioWeightDevice' => $blkioWeightDevice]);

        return $this;
    }

    /**
     * @param array $blkioDeviceReadBps
     *
     * @return Client
     */
    public function setBlkioDeviceReadBps(array $blkioDeviceReadBps)
    {
        $this->blkioDeviceReadBps = $blkioDeviceReadBps;

        $this->hostConfig = array_merge($this->hostConfig, ['BlkioDeviceReadBps' => $blkioDeviceReadBps]);

        return $this;
    }

    /**
     * @param array $blkioDeviceWriteBps
     *
     * @return Client
     */
    public function setBlkioDeviceWriteBps(array $blkioDeviceWriteBps)
    {
        $this->blkioDeviceWriteBps = $blkioDeviceWriteBps;

        $this->hostConfig = array_merge($this->hostConfig, ['BlkioDeviceWriteBps' => $blkioDeviceWriteBps]);

        return $this;
    }

    /**
     * @param array $blkioDeviceReadIOps
     *
     * @return Client
     */
    public function setBlkioDeviceReadIOps(array $blkioDeviceReadIOps)
    {
        $this->blkioDeviceReadIOps = $blkioDeviceReadIOps;

        $this->hostConfig = array_merge($this->hostConfig, ['BlkioDeviceReadIOps' => $blkioDeviceReadIOps]);

        return $this;
    }

    /**
     * @param array $blkioDeviceWriteIOps
     *
     * @return Client
     */
    public function setBlkioDeviceWriteIOps(array $blkioDeviceWriteIOps)
    {
        $this->blkioDeviceWriteIOps = $blkioDeviceWriteIOps;

        $this->hostConfig = array_merge($this->hostConfig, ['BlkioDeviceWriteIOps' => $blkioDeviceWriteIOps]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['CpuPeriod' => $cpuPeriod]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['CpuQuota' => $cpuQuota]);

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

        $this->hostConfig = array_merge($this->hostConfig, [' CpuRealtimePeriod ' => $cpuRealtimePeriod]);

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

        $this->hostConfig = array_merge($this->hostConfig, [' CpuRealtimeRuntime ' => $cpuRealtimeRuntime]);

        return $this;
    }

    /**
     * @param string $cpusetCpus CPUs in which to allow execution (e.g., 0-3, 0,1)
     *
     * @return Client
     */
    public function setCpusetCpus(string $cpusetCpus)
    {
        $this->cpusetCpus = $cpusetCpus;

        $this->hostConfig = array_merge($this->hostConfig, [' CpusetCpus' => $cpusetCpus]);

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

        $this->hostConfig = array_merge($this->hostConfig, [' CpusetMems ' => $cpusetMems]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Devices' => $devices]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['DeviceCgroupRules' => $deviceCgroupRules]);

        return $this;
    }

    /**
     * @param int $diskQuote disk limit (in bytes)
     *
     * @return Client
     */
    public function setDiskQuote(int $diskQuote)
    {
        $this->diskQuote = $diskQuote;

        $this->hostConfig = array_merge($this->hostConfig, ['DiskQuota ' => $diskQuote]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['KernelMemory' => $kernelMemory]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['MemoryReservation ' => $memoryReservation]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['MemorySwap' => $memorySwap]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['MemorySwappiness ' => $memorySwappiness]);

        return $this;
    }

    /**
     * @param int $nanoCPUs
     *
     * @return Client
     */
    public function setNanoCPUs(int $nanoCPUs)
    {
        $this->NanoCPUs = $nanoCPUs;

        $this->hostConfig = array_merge($this->hostConfig, ['NanoCPUs' => $nanoCPUs]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['OomKillDisable ' => $oomKillDisable]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Init' => $init]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['PidsLimit' => $pidsLimit]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Ulimits' => $ulimits]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['CpuCount' => $cpuCount]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['CpuPercent' => $cpuPercent]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['IOMaximumIOps' => $IOMaximumIOps]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['IOMaximumBandwidth' => $IOMaximumBandWidth]);

        return $this;
    }

    /**
     * @param array $binds
     *
     * [
     * "host-src:container-dest",
     * "host-src:container-dest:ro",
     * "volume-name:container-dest",
     * "volume-name:container-dest:ro"
     * ]
     *
     * @return Client
     */
    public function setBinds(array $binds)
    {
        $this->binds = $binds;

        $this->hostConfig = array_merge($this->hostConfig, ['Binds' => $binds]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['ContainerIDFile' => $containerIDFile]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['LogConfig' => $logConfig]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['NetworkMode' => $networkMode]);

        return $this;
    }

    /**
     * @param array $portBindings
     *
     * [ "80/tcp" => [
     *   [
     *     "HostIp" => "",
     *     "HostPort" => "80"
     *   ],
     * ],
     *   "443/tcp" => [
     *   [
     *     "HostIp"=>"",
     *     "HostPort"=> "443"
     *   ],
     * ],
     * ]
     *
     * @return Client
     */
    public function setPortBindings(array $portBindings)
    {
        $this->PortBindings = $portBindings;

        $this->hostConfig = array_merge($this->hostConfig, ['PortBindings' => $portBindings]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['RestartPolicy' => $restartPolicy]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['AutoRemove' => $autoRemove]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['VolumeDriver' => $volumeDriver]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['VolumesFrom' => $volumesFrom]);

        return $this;
    }

    /**
     * @param array $mounts
     *                      [["Type" => "bind","Source" => "/host_mnt/c","Destination" => "/data",
     *                      "Mode" => "","RW" => true,"Propagation" => "rprivate"],
     *                      ]
     *
     * @return Client
     */
    public function setMounts(array $mounts)
    {
        $this->mounts = $mounts;

        $this->hostConfig = array_merge($this->hostConfig, ['Mounts' => $mounts]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['CapAdd' => $capAdd]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['CapDrop' => $capDrop]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Dns' => $dns]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['DnsOptions' => $dnsOptions]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['DnsSearch' => $dnsSearch]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['ExtraHosts' => $extraHosts]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['GroupAdd' => $groupAdd]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['IpcMode' => $ipcMode]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Cgroup' => $Cgroup]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['OomScoreAdj' => $oomScoreAdj]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['PidMode' => $pidMode]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Privileged' => $privileged]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['PublishAllPorts' => $publishAllPorts]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['ReadonlyRootfs' => $readonlyRootfs]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['SecurityOpt' => $securityOpt]);

        return $this;
    }

    /**
     * @param array $storageOpt
     *
     * @return Client
     */
    public function setStorageOpt(array $storageOpt)
    {
        $this->StorageOpt = $storageOpt;

        $this->hostConfig = array_merge($this->hostConfig, ['StorageOpt' => $storageOpt]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Tmpfs' => $tmpfs]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['UTSMode' => $UTSMode]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['UsernsMode' => $usernsMode]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['ShmSize' => $shmSize]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Sysctls' => $sysctls]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Runtime' => $runtime]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['ConsoleSize' => $consoleSize]);

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

        $this->hostConfig = array_merge($this->hostConfig, ['Isolation' => $isolation]);

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
     * @return mixed 200
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
     * @param bool $returnID
     *
     * @return string|Client 201
     *
     * @throws Exception
     */
    public function create(bool $returnID = false)
    {
        $url = self::$base_url.'/'.__FUNCTION__.'?'.http_build_query(['name' => $this->container_name]);

        if (!$this->image) {
            throw new Exception('Image Not Found, please set image', 404);
        }

        $request = json_encode(array_merge($this->raw, ['HostConfig' => $this->hostConfig]));

        $json = self::$curl->post($url, $request, self::$header);

        $id = json_decode($json)->Id ?? null;

        if (null === $id) {
            throw new Exception(json_decode($json)->message, self::$curl->getCode());
        }

        $this->container_id = $id;

        // clean raw

        $this->create_raw = $this->raw;

        $this->hostConfig = [];

        $this->networkingConfig = [];

        $this->raw = [];

        if ($returnID) {
            return $id;
        }

        return $this;
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
     * @param string|null $id
     * @param bool        $size
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function inspect(?string $id, bool $size = false)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/json?'.http_build_query(['size' => $size]);

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
     * @return mixed 200
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
     * @return mixed 101 200
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

        $url = self::$base_url.'/'.($id ?? $this->container_id).'/'.__FUNCTION__.'?'.http_build_query($data);

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
     * @return mixed 200
     *
     * @throws Exception
     */
    public function changes(?string $id)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/'.__FUNCTION__;

        return self::$curl->get($url);
    }

    /**
     * Export a container.
     *
     * Export the contents of a container as a tarball.
     *
     * @param string|null $id
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function export(string $id)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/'.__FUNCTION__;

        return self::$curl->get($url);
    }

    /**
     * Get container stats based on resource usage.
     *
     * @param string|null $id
     * @param bool        $stream Stream the output. If false, the stats will be output once and then it will
     *                            disconnect.
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function stats(?string $id, bool $stream = false)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/stats?'.http_build_query(['stream' => $stream]);

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
     * @return mixed 200
     *
     * @throws Exception
     */
    public function resize(?string $id, int $height, int $width)
    {
        $data = [
            'height' => $height,
            'width' => $width,
        ];

        $url = self::$base_url.'/'.($id ?? $this->container_id).'/resize?'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id         ID or name of the container
     * @param string|null $detachKeys Override the key sequence for detaching a container.
     *                                Format is a single character `[a-Z]`
     *                                or `ctrl-<value>` where <value> is one of: `a-z`,`@`,`^`,`[`,`,` or `_`.
     *
     * @return string 204 304
     *
     * @throws Exception
     */
    public function start(?string $id, string $detachKeys = null)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/start?'.http_build_query(['detachKeys' => $detachKeys]);

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
     * @return mixed 204 304
     *
     * @throws Exception
     */
    public function stop(?string $id, int $waitTime = 0)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/stop?'.http_build_query(['t' => $waitTime]);

        $output = self::$curl->post($url);

        $http_return_code = self::$curl->getCode();

        if (204 === $http_return_code) {
            return null;
        }

        throw new Exception(json_decode($output)->message, $http_return_code);
    }

    /**
     * @param string|null $id
     * @param int         $waitTime
     *
     * @return mixed 204
     *
     * @throws Exception
     */
    public function restart(?string $id, int $waitTime = 0)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/restart?'.http_build_query(['t' => $waitTime]);

        $output = self::$curl->post($url);

        $http_return_code = self::$curl->getCode();

        if (204 === $http_return_code) {
            return null;
        }

        throw new Exception(json_decode($output)->message, $http_return_code);
    }

    /**
     * @param string|null $id
     * @param string      $signal
     *
     * @return mixed 204
     *
     * @throws Exception
     */
    public function kill(?string $id, string $signal = 'SIGKILL')
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/kill?'.http_build_query(['signal' => $signal]);

        $output = self::$curl->post($url);

        $http_return_code = self::$curl->getCode();

        if (204 === $http_return_code) {
            return null;
        }

        throw new Exception(json_decode($output)->message, $http_return_code);
    }

    /**
     * @param string|null $id
     *
     * @return mixed 200
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ContainerUpdate
     */
    public function update(?string $id)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/update';

        $request = json_encode($request = $this->hostConfig);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * @param string|null $id
     * @param string      $name
     *
     * @return mixed 204
     *
     * @throws Exception
     */
    public function rename(?string $id, string $name)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/rename?'.http_build_query(['name' => $name]);

        $output = self::$curl->post($url);

        $http_return_code = self::$curl->getCode();

        if (204 === $http_return_code) {
            return null;
        }

        throw new Exception(json_decode($output)->message, $http_return_code);
    }

    /**
     * @param string|null $id
     *
     * @return mixed 204
     *
     * @throws Exception
     */
    public function pause(?string $id)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/pause';

        $output = self::$curl->post($url);

        $http_return_code = self::$curl->getCode();

        if (204 === $http_return_code) {
            return null;
        }

        throw new Exception(json_decode($output)->message, $http_return_code);
    }

    /**
     * @param string|null $id
     *
     * @return mixed 204
     *
     * @throws Exception
     */
    public function unpause(?string $id)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/unpause';

        $output = self::$curl->post($url);

        $http_return_code = self::$curl->getCode();

        if (204 === $http_return_code) {
            return null;
        }

        throw new Exception(json_decode($output)->message, $http_return_code);
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
     * @return mixed 101 200
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ContainerAttach
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

        $url = self::$base_url.'/'.($id ?? $this->container_id).'/attach?'.http_build_query($data);

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
     * @return mixed 101 200
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ContainerAttachWebsocket
     */
    public function attachViaWebSocket(?string $id,
                                       string $detachKeys = null,
                                       bool $logs = false,
                                       bool $stream = false,
                                       bool $stdin = false,
                                       bool $stdout = false,
                                       bool $stderr = false)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/attach/ws?'.http_build_query([
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
     * @param string      $condition wait until a container state reaches the given condition,
     *                               either 'not - running'(default), 'next - exit', or 'removed'
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function wait(?string $id, string $condition = 'not - running')
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/wait?'.http_build_query(['condition' => $condition]);

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id
     * @param bool        $v
     * @param bool        $force
     * @param bool        $link
     *
     * @return mixed 204
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

        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'?'.http_build_query($data);

        $output = self::$curl->delete($url);

        $http_return_code = self::$curl->getCode();

        if (204 === $http_return_code) {
            return null;
        }

        throw new Exception(json_decode($output)->message, $http_return_code);
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
     * @return mixed 200
     *
     * @throws Exception
     */
    public function getFileInfo(?string $id, string $path)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/archive?'.http_build_query([
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
     * @return mixed 200
     *
     * @throws Exception
     */
    public function archive(?string $id, string $path)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/archive?'.http_build_query(['path' => $path]);

        return self::$curl->get($url);
    }

    /**
     * Extract an archive of files or folders to a directory in a container.
     *
     * @param string|null $id
     * @param string      $path                 path to a directory in the container to extract the archive’s contents
     *                                          into
     * @param bool        $noOverwriteDirNonDir if “1”, “true”, or “True” then it will be an error if unpacking the
     *                                          given content would cause an existing directory to be replaced with a
     *                                          non-directory and vice versa
     * @param string      $request
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function extract(?string $id, string $path, bool $noOverwriteDirNonDir, string $request)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/archive?'.http_build_query([
                'path' => $path,
                'noOverwriteDirNonDir' => $noOverwriteDirNonDir,
            ]);

        $output = self::$curl->put($url, $request);

        $http_return_code = self::$curl->getCode();

        if (200 === $http_return_code) {
            return null;
        }

        throw new Exception(json_decode($output)->message, $http_return_code);
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
     * @return mixed 200
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
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/exec';

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
        $url = self::$base_url.'/exec'.($id ?? $this->container_id).'/start';

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

        $url = self::$base_url.'/exec'.($id ?? $this->container_id).'/resize?'.http_build_query($data);

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
