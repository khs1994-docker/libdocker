<?php

namespace Docker\Module;

trait ContainerTrait
{
    public $hostname;

    public $domainname;

    public $user;

    public $ExposedPorts;

    public $env;

    public $healthcheck;

    public $volumes;

    public $workingDir;

    public $entrypoint;

    public $macAddress;

    public $onBuild;

    public $labels;

    public $stopSignal;

    public $stopTimeout;

    public $shell;

    public $hostConfig;

    public $networkingConfig;

    public $hostBindingPort;

    public $otherConfig;

    public function setContainer($data)
    {
        $array = get_class_vars(__CLASS__);

        $config = [];

        foreach ($array as $k => $v) {
            if ($k === 'header') {
                unset($array[$k]);
            }
        }

        foreach ($array as $k => $v) {
            if ($v == null) {
                $k = ucfirst($k);
                $config[$k] = $v;
            }
        }

        $data = array_merge($data, $config);

        var_dump($data);

        exit();

        return $data;
    }

    /**
     * @return mixed
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param mixed $hostname
     */
    public function setHostname($hostname): void
    {
        $this->hostname = $hostname;
    }

    /**
     * @return mixed
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param mixed $domainname
     */
    public function setDomainname($domainname): void
    {
        $this->domainname = $domainname;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getExposedPorts()
    {
        return $this->ExposedPorts;
    }

    /**
     * @param mixed $ExposedPorts
     */
    public function setExposedPorts($ExposedPorts): void
    {
        $this->ExposedPorts = $ExposedPorts;
    }

    /**
     * @return mixed
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @param mixed $env
     */
    public function setEnv($env): void
    {
        $this->env = $env;
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
     * @return mixed
     */
    public function getVolumes()
    {
        return $this->volumes;
    }

    /**
     * @param mixed $volumes
     */
    public function setVolumes($volumes): void
    {
        $this->volumes = $volumes;
    }

    /**
     * @return mixed
     */
    public function getWorkingDir()
    {
        return $this->workingDir;
    }

    /**
     * @param mixed $workingDir
     */
    public function setWorkingDir($workingDir): void
    {
        $this->workingDir = $workingDir;
    }

    /**
     * @return mixed
     */
    public function getEntrypoint()
    {
        return $this->entrypoint;
    }

    /**
     * @param mixed $entrypoint
     */
    public function setEntrypoint($entrypoint): void
    {
        $this->entrypoint = $entrypoint;
    }

    /**
     * @return mixed
     */
    public function getMacAddress()
    {
        return $this->macAddress;
    }

    /**
     * @param mixed $macAddress
     */
    public function setMacAddress($macAddress): void
    {
        $this->macAddress = $macAddress;
    }

    /**
     * @return mixed
     */
    public function getOnBuild()
    {
        return $this->onBuild;
    }

    /**
     * @param mixed $onBuild
     */
    public function setOnBuild($onBuild): void
    {
        $this->onBuild = $onBuild;
    }

    /**
     * @return mixed
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param mixed $labels
     */
    public function setLabels($labels): void
    {
        $this->labels = $labels;
    }

    /**
     * @return mixed
     */
    public function getStopSignal()
    {
        return $this->stopSignal;
    }

    /**
     * @param mixed $stopSignal
     */
    public function setStopSignal($stopSignal): void
    {
        $this->stopSignal = $stopSignal;
    }

    /**
     * @return mixed
     */
    public function getStopTimeout()
    {
        return $this->stopTimeout;
    }

    /**
     * @param mixed $stopTimeout
     */
    public function setStopTimeout($stopTimeout): void
    {
        $this->stopTimeout = $stopTimeout;
    }

    /**
     * @return mixed
     */
    public function getShell()
    {
        return $this->shell;
    }

    /**
     * @param mixed $shell
     */
    public function setShell($shell): void
    {
        $this->shell = $shell;
    }

    /**
     * @return mixed
     */
    public function getHostConfig()
    {
        return $this->hostConfig;
    }

    /**
     * @param mixed $hostConfig
     */
    public function setHostConfig($hostConfig): void
    {
        $this->hostConfig = $hostConfig;
    }

    /**
     * @return mixed
     */
    public function getNetworkingConfig()
    {
        return $this->networkingConfig;
    }

    /**
     * @param mixed $networkingConfig
     */
    public function setNetworkingConfig($networkingConfig): void
    {
        $this->networkingConfig = $networkingConfig;
    }

    /**
     * @return mixed
     */
    public function getHostBindingPort()
    {
        return $this->hostBindingPort;
    }

    /**
     * @param mixed $hostBindingPort
     */
    public function setHostBindingPort($hostBindingPort): void
    {
        $this->hostBindingPort = $hostBindingPort;
    }

    /**
     * @return mixed
     */
    public function getOtherConfig()
    {
        return $this->otherConfig;
    }

    /**
     * @param mixed $otherConfig
     */
    public function setOtherConfig($otherConfig): void
    {
        $this->otherConfig = $otherConfig;
    }


}