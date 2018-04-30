<?php

namespace Docker\Module;

trait ContainerTrait
{
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

    public function setHostConfig(array $binds = null,
                                  array $portBindings = null,
                                  array $restartPolicy = null,
                                  array $mounts = null,
                                  array $dns = null,
                                  array $extraHosts = null)
    {
        $this->hostConfig = array_filter([
            'Binds' => $binds,
            'PortBindings' => $portBindings,
            'RestartPolicy' => $restartPolicy,
            'Mounts' => $mounts,
            'Dns' => $dns,
            'ExtraHosts' => $extraHosts,
        ]);
    }

    private $networkingConfig;

    public function setNetworkingConfig()
    {

    }

    public function setContainer(array $data)
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

            if ($v == null) {
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
     */
    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
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
     */
    public function setDomainname(string $domainname): void
    {
        $this->domainname = $domainname;
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
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
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
     */
    public function setAttachStdin(bool $attachStdin): void
    {
        $this->attachStdin = $attachStdin;
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
     */
    public function setAttachStdout(bool $attachStdout): void
    {
        $this->attachStdout = $attachStdout;
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
     */
    public function setAttachStderr(bool $attachStderr): void
    {
        $this->attachStderr = $attachStderr;
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
     */
    public function setExposedPorts(array $ExposedPorts): void
    {
        $this->ExposedPorts = $ExposedPorts;
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
     */
    public function setTty(bool $tty): void
    {
        $this->tty = $tty;
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
     */
    public function setOpenStdin(bool $openStdin): void
    {
        $this->openStdin = $openStdin;
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
     */
    public function setStdinOnce(bool $stdinOnce): void
    {
        $this->stdinOnce = $stdinOnce;
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
     */
    public function setEnv(array $env): void
    {
        $envArray = [];

        foreach ($env as $k => $v) {
            $envArray[] = "$k=$v";
        }

        $this->env = $envArray;
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
     */
    public function setHealthcheck($healthcheck): void
    {
        $this->healthcheck = $healthcheck;
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
     */
    public function setArgsEscaped(bool $argsEscaped): void
    {
        $this->argsEscaped = $argsEscaped;
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
     */
    public function setVolumes(array $volumes): void
    {
        $this->volumes = $volumes;
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
     */
    public function setWorkingDir(string $workingDir): void
    {
        $this->workingDir = $workingDir;
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
     */
    public function setEntrypoint($entrypoint): void
    {
        $this->entrypoint = $entrypoint;
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
     */
    public function setNetworkDisabled(bool $networkDisabled): void
    {
        $this->networkDisabled = $networkDisabled;
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
     */
    public function setMacAddress(string $macAddress): void
    {
        $this->macAddress = $macAddress;
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
     */
    public function setOnBuild($onBuild): void
    {
        $this->onBuild = $onBuild;
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
     */
    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
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
     */
    public function setStopSignal(string $stopSignal): void
    {
        $this->stopSignal = $stopSignal;
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
     */
    public function setStopTimeout(int $stopTimeout): void
    {
        $this->stopTimeout = $stopTimeout;
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
     */
    public function setShell($shell): void
    {
        $this->shell = $shell;
    }


}
