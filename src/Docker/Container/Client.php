<?php

declare(strict_types=1);

namespace Docker\Container;

use Curl\Curl;
use Docker\Image\Client as Image;
use Exception;

/**
 * Container.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Container
 */
class Client
{
    private const TYPE = 'containers';

    /**
     * @var Curl
     */
    private static $curl;

    private static $base_url;

    private static $header = ['content-type' => 'application/json'];

    /**
     * @var Image
     */
    private $docker_image;

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
     * @var string
     */
    private $create_raw = null;

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
     *                   null => 默认值，Dockerfile 中指定的值
     *                   [] => 默认值，Dockerfile 中指定的值
     *                   [""] => ""
     *
     * @return Client
     */
    public function setCmd(?array $cmd = null)
    {
        $this->cmd = $cmd;

        $this->raw = array_merge($this->raw, ['Cmd' => $cmd]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setImage(string $image)
    {
        $this->image = $image;

        $this->raw = array_merge($this->raw, ['Image' => $image]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setContainerName(string $container_name)
    {
        $this->container_name = $container_name;

        return $this;
    }

    /**
     * @example
     * <pre>
     * [
     *     'EndpointsConfig' => [
     *         'network_name' => [
     *             'Aliases' => [ 'nginx' ]
     *         ]
     *      ]
     * ]
     * <pre>
     *
     * @return Client
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ContainerCreate
     */
    public function setNetworkingConfig(array $networkingConfig)
    {
        $this->networkingConfig = $networkingConfig;

        $this->raw = array_merge($this->raw, ['NetworkingConfig' => $networkingConfig]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;

        $this->raw = array_merge($this->raw, ['Hostname' => $hostname]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setDomainname(string $domainname)
    {
        $this->domainname = $domainname;

        $this->raw = array_merge($this->raw, ['Domainname' => $domainname]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setUser(string $user)
    {
        $this->user = $user;

        $this->raw = array_merge($this->raw, ['User' => $user]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setAttachStdin(bool $attachStdin = false)
    {
        $this->attachStdin = $attachStdin;

        $this->raw = array_merge($this->raw, ['AttachStdin' => $attachStdin]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setAttachStdout(bool $attachStdout = false)
    {
        $this->attachStdout = $attachStdout;

        $this->raw = array_merge($this->raw, ['AttachStdout' => $attachStdout]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setAttachStderr(bool $attachStderr = false)
    {
        $this->attachStderr = $attachStderr;

        $this->raw = array_merge($this->raw, ['AttachStderr' => $attachStderr]);

        return $this;
    }

    /**
     * @param array $exposedPorts ["22/<tcp|udp|sctp>":{}]
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
     * @return Client
     */
    public function setTty(bool $tty = false)
    {
        $this->tty = $tty;

        $this->raw = array_merge($this->raw, ['Tty' => $tty]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setOpenStdin(bool $openStdin = false)
    {
        $this->openStdin = $openStdin;

        $this->raw = array_merge($this->raw, ['OpenStdin' => $openStdin]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setStdinOnce(bool $stdinOnce = false)
    {
        $this->stdinOnce = $stdinOnce;

        $this->raw = array_merge($this->raw, ['StdinOnce' => $stdinOnce]);

        return $this;
    }

    /**
     * @param array<string>|null $env ['env=value']
     *
     * @return Client
     */
    public function setEnv(?array $env)
    {
        $this->env = $env;

        $this->raw = array_merge($this->raw, ['Env' => $env]);

        return $this;
    }

    /**
     * @param array<string> $test
     *                                1. [] inherit healthcheck from image or parent image
     *                                2. ["NONE"] disable healthcheck
     *                                3. ["CMD", args...] exec arguments directly
     *                                4. ["CMD-SHELL", command] run command with system's default shell
     * @param int           $interval 0 means inherit
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
     * Command is already escaped (Windows only).
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
     * @param array $volumes [ "path" : {} ]
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
     * @return Client
     */
    public function setWorkingDir(string $workingDir)
    {
        $this->workingDir = $workingDir;

        $this->raw = array_merge($this->raw, ['WorkingDir' => $workingDir]);

        return $this;
    }

    /**
     * @param array<string> $entrypoint ['/bin/sh', '-c']
     *                                  1. [] => []
     *                                  2. null => 默认值，Dockerfile 中指定的值
     *                                  3. [""] => If the array consists of exactly one
     *                                  empty string ([""]) then the entry point is
     *                                  reset to system default (i.e., the entry point
     *                                  used by docker when there is no ENTRYPOINT
     *                                  instruction in the Dockerfile).
     *
     * @return Client
     */
    public function setEntrypoint(?array $entrypoint = null)
    {
        $this->entrypoint = $entrypoint;

        $this->raw = array_merge($this->raw, ['Entrypoint' => $entrypoint]);

        return $this;
    }

    /**
     * Disable networking for the container.
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
     * @return Client
     */
    public function setMacAddress(string $macAddress)
    {
        $this->macAddress = $macAddress;

        $this->raw = array_merge($this->raw, ['MacAddress' => $macAddress]);

        return $this;
    }

    /**
     * @param array<string> $onBuild
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
     * @return Client
     */
    public function setStopSignal(string $stopSignal = 'SIGTERM')
    {
        $this->stopSignal = $stopSignal;

        $this->raw = array_merge($this->raw, ['StopSignal' => $stopSignal]);

        return $this;
    }

    /**
     * Timeout to stop a container in seconds.
     *
     * @return Client
     */
    public function setStopTimeout(int $stopTimeout = 10)
    {
        $this->stopTimeout = $stopTimeout;

        $this->raw = array_merge($this->raw, ['StopTimeout' => $stopTimeout]);

        return $this;
    }

    /**
     * @param array<string> $shell
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
     * @return Client
     */
    public function setCpuShares(int $cpuShares)
    {
        $this->cpuShares = $cpuShares;

        $this->hostConfig = array_merge($this->hostConfig, ['CpuShares' => $cpuShares]);

        return $this;
    }

    /**
     * Memory limit in bytes.
     *
     * @return Client
     */
    public function setMemory(int $memory = 0)
    {
        $this->memory = $memory;

        $this->hostConfig = array_merge($this->hostConfig, ['Memory' => $memory]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setCgroupParent(string $cgroupParent)
    {
        $this->CgroupParent = $cgroupParent;

        $this->hostConfig = array_merge($this->hostConfig, ['CgroupParent' => $cgroupParent]);

        return $this;
    }

    /**
     * [ 0 .. 1000 ].
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
     * $param array<object> $blkioWeightDevice.
     *
     * [{"Path": "device_path", "Weight": weight}].
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
     * [{"Path": "device_path", "Rate": rate}].
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
     * [{"Path": "device_path", "Rate": rate}].
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
     * [{"Path": "device_path", "Rate": rate}].
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
     * [{"Path": "device_path", "Rate": rate}].
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
     * The length of a CPU period in microseconds.
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
     * @return Client
     */
    public function setCpuQuota(int $cpuQuota)
    {
        $this->cpuQuota = $cpuQuota;

        $this->hostConfig = array_merge($this->hostConfig, ['CpuQuota' => $cpuQuota]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setCpuRealtimePeriod(int $cpuRealtimePeriod)
    {
        $this->cpuRealtimePeriod = $cpuRealtimePeriod;

        $this->hostConfig = array_merge($this->hostConfig, [' CpuRealtimePeriod ' => $cpuRealtimePeriod]);

        return $this;
    }

    /**
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
     * Memory nodes (MEMs) in which to allow execution (0-3, 0,1). Only effective on NUMA systems.
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
     * @return Client
     */
    public function setDevices(array $devices)
    {
        $this->devices = $devices;

        $this->hostConfig = array_merge($this->hostConfig, ['Devices' => $devices]);

        return $this;
    }

    /**
     * @param array<string> $deviceCgroupRules
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
     * Kernel memory limit in bytes.
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
     * Memory soft limit in bytes.
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
     * Total memory limit (memory + swap). Set as -1 to enable unlimited swap.
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
     * [ 0 .. 100 ].
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
     * @return Client
     */
    public function setNanoCPUs(int $nanoCPUs)
    {
        $this->NanoCPUs = $nanoCPUs;

        $this->hostConfig = array_merge($this->hostConfig, ['NanoCPUs' => $nanoCPUs]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setOomKillDisable(bool $oomKillDisable)
    {
        $this->oomKillDisable = $oomKillDisable;

        $this->hostConfig = array_merge($this->hostConfig, ['OomKillDisable ' => $oomKillDisable]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setInit(?bool $init)
    {
        $this->init = $init;

        $this->hostConfig = array_merge($this->hostConfig, ['Init' => $init]);

        return $this;
    }

    /**
     * Tune a container's PIDs limit. Set 0 or -1 for unlimited, or null to not change.
     *
     * @return Client
     */
    public function setPidsLimit(?int $pidsLimit)
    {
        $this->pidsLimit = $pidsLimit;

        $this->hostConfig = array_merge($this->hostConfig, ['PidsLimit' => $pidsLimit]);

        return $this;
    }

    /**
     * {"Name": "nofile", "Soft": 1024, "Hard": 2048}.
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
     * The number of usable CPUs (Windows only).
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
     * The usable percentage of the available CPUs (Windows only).
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
     * Maximum IOps for the container system drive (Windows only).
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
     * Maximum IO in bytes per second for the container system drive (Windows only).
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
     * @param array<string> $binds
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
     * @return Client
     */
    public function setContainerIDFile(string $containerIDFile)
    {
        $this->containerIDFile = $containerIDFile;

        $this->hostConfig = array_merge($this->hostConfig, ['ContainerIDFile' => $containerIDFile]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setLogConfig(array $logConfig)
    {
        $this->logConfig = $logConfig;

        $this->hostConfig = array_merge($this->hostConfig, ['LogConfig' => $logConfig]);

        return $this;
    }

    /**
     * bridge, host, none, and container:<name|id>.
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
     * "" "always" "unless-stopped" "on-failure".
     *
     * ['Name' => '','MaximumRetryCount'=>'int']
     *
     * MaximumRetryCount: If on-failure is used, the number of times to retry before giving up
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
     * Automatically remove the container when the container's process exits.
     * This has no effect if RestartPolicy is set.
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
     * Driver that this container uses to mount volumes.
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
     * A list of volumes to inherit from another container,
     * specified in the form <container name>[:<ro|rw>].
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
     *                      <pre>
     *                      [
     *                      ["Type" => "bind",
     *                      "Source" => "/host_mnt/c",
     *                      "Destination" => "/container/path",
     *                      "Mode" => "",
     *                      "RW" => true,
     *                      "Propagation" => "rprivate"
     *                      ],
     *                      [
     *                      ]
     *                      ]
     *                      </pre>
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
     * @return Client
     */
    public function setCapAdd(array $capAdd)
    {
        $this->capAdd = $capAdd;

        $this->hostConfig = array_merge($this->hostConfig, ['CapAdd' => $capAdd]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setCapDrop(array $capDrop)
    {
        $this->capDrop = $capDrop;

        $this->hostConfig = array_merge($this->hostConfig, ['CapDrop' => $capDrop]);

        return $this;
    }

    /**
     * @param array<string> $dns
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
     * @param array<string> $dnsOptions
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
     * @param array<string> $dnsSearch
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
     * @param array<string> $extraHosts ["hostname:IP"]
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
     * @param array<string> $groupAdd
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
     * @return Client
     */
    public function setIpcMode(string $ipcMode)
    {
        $this->ipcMode = $ipcMode;

        $this->hostConfig = array_merge($this->hostConfig, ['IpcMode' => $ipcMode]);

        return $this;
    }

    /**
     * Cgroup to use for the container.
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
     * @return Client
     */
    public function setOomScoreAdj(int $oomScoreAdj)
    {
        $this->oomScoreAdj = $oomScoreAdj;

        $this->hostConfig = array_merge($this->hostConfig, ['OomScoreAdj' => $oomScoreAdj]);

        return $this;
    }

    /**
     * "container:<name|id>" | "host".
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
     * @return Client
     */
    public function setPrivileged(bool $privileged)
    {
        $this->privileged = $privileged;

        $this->hostConfig = array_merge($this->hostConfig, ['Privileged' => $privileged]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setPublishAllPorts(bool $publishAllPorts)
    {
        $this->publishAllPorts = $publishAllPorts;

        $this->hostConfig = array_merge($this->hostConfig, ['PublishAllPorts' => $publishAllPorts]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setReadonlyRootfs(bool $readonlyRootfs)
    {
        $this->readonlyRootfs = $readonlyRootfs;

        $this->hostConfig = array_merge($this->hostConfig, ['ReadonlyRootfs' => $readonlyRootfs]);

        return $this;
    }

    /**
     * @param array<string> $securityOpt
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
     * {"size": "120G"}.
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
     * { "/run": "rw,noexec,nosuid,size=65536k" }.
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
     * @return Client
     */
    public function setUTSMode(string $UTSMode)
    {
        $this->UTSMode = $UTSMode;

        $this->hostConfig = array_merge($this->hostConfig, ['UTSMode' => $UTSMode]);

        return $this;
    }

    /**
     * @return Client
     */
    public function setUsernsMode(string $usernsMode)
    {
        $this->usernsMode = $usernsMode;

        $this->hostConfig = array_merge($this->hostConfig, ['UsernsMode' => $usernsMode]);

        return $this;
    }

    /**
     * >= 0.
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
     * {"net.ipv4.ip_forward": "1"}.
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
     * @return Client
     */
    public function setRuntime(string $runtime)
    {
        $this->runtime = $runtime;

        $this->hostConfig = array_merge($this->hostConfig, ['Runtime' => $runtime]);

        return $this;
    }

    /**
     * item integer >= 0.
     *
     * Initial console size, as an [height, width] array. (Windows only)
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
     *  "default" "process" "hyperv".
     *
     * Isolation technology of the container. (Windows only)
     *
     * @return Client
     */
    public function setIsolation(string $isolation)
    {
        $this->isolation = $isolation;

        $this->hostConfig = array_merge($this->hostConfig, ['Isolation' => $isolation]);

        return $this;
    }

    public function getContainerId(): string
    {
        return $this->container_id;
    }

    public function setContainerId(string $container_id): void
    {
        $this->container_id = $container_id;
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public static function checkFilter(string $type, array $filters)
    {
        $filters_array_define = 'filters_array_'.$type;

        try {
            $filters_array_define = self::$$filters_array_define;
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage(), 500);
        }

        $filters_array = [];

        foreach ($filters as $filter => $v) {
            if (!\in_array($filter, $filters_array_define, true)) {
                throw new Exception($filter, 500);
            }

            if (\is_array($v)) {
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
    public function __construct($curl, $docker_host, $image)
    {
        self::$curl = $curl;
        self::$base_url = $docker_host.'/'.self::TYPE;
        $this->docker_image = $image;
    }

    /**
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
            $filters = $this->checkFilter(__FUNCTION__, $filters);
        }

        $url = self::$base_url.'/json?'.http_build_query(
            array_merge(compact('all', 'limit', 'size'), compact('filters'))
        );

        return self::$curl->get($url);
    }

    /**
     * @return $this
     *
     * @throws Exception
     */
    public function setCreateJson(?string $create_raw)
    {
        if ($create_raw) {
            $this->create_raw = $create_raw;

            $this->image = json_decode($this->create_raw)->Image;

            return $this;
        }

        if ($this->create_raw) {
            $this->image = json_decode($this->create_raw)->Image;

            return $this;
        }

        // 没有传入，进行拼接
        if (!$this->image) {
            throw new Exception('Image Not Found, please set image', 404);
        }

        $request = json_encode($this->raw);

        // 拼接 hostConfig
        if ($this->hostConfig) {
            $request = json_encode(array_merge($this->raw, ['HostConfig' => $this->hostConfig]));
        }

        $this->create_raw = $request;

        return $this;
    }

    private function cleanupConfig(): void
    {
        $this->hostConfig = [];

        $this->image = null;

        $this->networkingConfig = [];

        $this->raw = [];

        $this->create_raw = null;
    }

    /**
     * @return string
     */
    public function getCreateJson()
    {
        $create_raw = $this->create_raw;

        $this->cleanupConfig();

        return $create_raw;
    }

    /**
     * @return string|Client 201
     *
     * @throws Exception
     */
    public function create(bool $returnID = false, bool $pull_force = false)
    {
        $url = self::$base_url.'/'.__FUNCTION__.'?'.http_build_query(['name' => $this->container_name]);

        $this->setCreateJson(null);

        $this->docker_image->pull($this->image, 'latest', $pull_force);

        $json = self::$curl->post($url, $this->getCreateJson(), self::$header);

        $id = json_decode($json)->Id ?? null;

        if (null === $id) {
            throw new Exception(json_decode($json)->message ?? $json, self::$curl->getCode());
        }

        $this->container_id = $id;

        $this->container_name = null;
        $this->cleanupConfig();

        if ($returnID) {
            return $id;
        }

        return $this;
    }

    /**
     * Inspect a container.
     *
     * Return low-level information about a container.
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function inspect(?string $id, bool $size = false)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/json?'.http_build_query(compact('size'));

        return self::$curl->get($url);
    }

    /**
     * List processes running inside a container.
     *
     * On Unix systems, this is done by running the ps command. This endpoint is not supported on Windows.
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
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/'.__FUNCTION__.'?'.http_build_query(compact(
            'follow', 'stdout', 'stderr', 'since', 'until', 'timestamps', 'tail'
        ));

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
     * @param bool $stream Stream the output. If false, the stats will be output once and then it will
     *                     disconnect.
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
     * @param int $height Height of the tty session in characters
     * @param int $width  Width of the tty session in characters
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function resize(?string $id, int $height, int $width)
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/resize?'.http_build_query(compact(
            'height', 'width'
        ));

        return self::$curl->post($url);
    }

    /**
     * @param string|null $id         ID or name of the container
     * @param string|null $detachKeys override the key sequence for detaching a container.
     *                                Format is a single character `[a-Z]`
     *                                or `ctrl-<value>` where <value> is one of: `a-z`,`@`,`^`,`[`,`,` or `_`
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

        $url = self::$base_url.'/'.($id ?? $this->container_id).'/attach?'.http_build_query(compact(
            'detachKeys', 'logs', 'stream', 'stdin', 'stdout', 'stderr'
        ));

        return self::$curl->post($url);
    }

    /**
     * Attach to a container via a websocket.
     *
     * @param string $detachKeys
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
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/attach/ws?'.http_build_query(
            compact('detachKeys', 'logs', 'stream', 'stdin', 'stdout', 'stderr'));

        return self::$curl->get($url);
    }

    /**
     * Wait for a container.
     *
     * Block until a container stops, then returns the exit code.
     *
     * @param string $condition wait until a container state reaches the given condition,
     *                          either 'not - running'(default), 'next - exit', or 'removed'
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function wait(?string $id, string $condition = 'not - running')
    {
        $url = self::$base_url.'/'.($id ?? $this->container_id).'/wait?'.http_build_query(compact('condition'));

        return self::$curl->post($url);
    }

    /**
     * @return mixed 204
     *
     * @throws Exception
     */
    public function remove(?string $id, bool $v = false, bool $force = false, bool $link = false)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'?'.http_build_query(compact(
            'v', 'force', 'link'
        ));

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
     * @param string $path                 path to a directory in the container to extract the archive’s contents
     *                                     into
     * @param bool   $noOverwriteDirNonDir if “1”, “true”, or “True” then it will be an error if unpacking the
     *                                     given content would cause an existing directory to be replaced with a
     *                                     non-directory and vice versa
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function extract(?string $id, string $path, bool $noOverwriteDirNonDir, string $request)
    {
        $id = $id ?? $this->container_id;

        $url = self::$base_url.'/'.$id.'/archive?'.http_build_query(compact(
                'path',
                'noOverwriteDirNonDir'
            ));

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
        $filters = self::checkFilter(__FUNCTION__, $filters);

        $url = self::$base_url.'/prune?'.http_build_query(compact('filters'));

        return self::$curl->post($url);
    }

    /**
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
     * @return mixed
     *
     * @throws Exception
     */
    public function startExec(?string $id, bool $detach = false, bool $tty = false)
    {
        $url = self::$base_url.'/exec/'.($id ?? $this->container_id).'/start';

        $data = [
            'Detach' => $detach,
            'Tty' => $tty,
        ];

        $request = json_encode($data);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
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

        $url = self::$base_url.'/exec/'.($id ?? $this->container_id).'/resize?'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function inspectExec(string $id)
    {
        $url = self::$base_url.'/exec/'.$id.'/json';

        return self::$curl->get($url);
    }
}
