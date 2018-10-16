<?php

declare(strict_types=1);

namespace Docker\Kernel;

use Docker\Docker;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * 是否延时加载提供器。
     *
     * @var bool
     */
    protected $defer = true;

    public function boot(): void
    {
        $configPath = __DIR__.'/../../../config/docker.php';

        $this->publishes([$configPath => config_path('docker.php')], 'config');
    }

    public function register(): void
    {
        $configPath = __DIR__.'/../../../config/docker.php';

        $this->mergeConfigFrom($configPath, 'docker');

        $this->app->singleton('docker', function () {
            $host_name = config('docker.default');

            return Docker::docker(Docker::createOptionArray(
                config('docker.hosts.'.$host_name.'.host', '127.0.0.1:2375'),
                config('docker.hosts.'.$host_name.'.tls_verify') ?? config('docker.tls_verify'),
                config('docker.hosts.'.$host_name.'.cert_path') ?? config('docker.cert_path'),
                config('docker.hosts.'.$host_name.'.username') ?? config('docker.username'),
                config('docker.hosts.'.$host_name.'.password') ?? config('docker.password'),
                config('docker.hosts.'.$host_name.'.registry') ?? config('docker.registry'),
                config('docker.hosts.'.$host_name.'.timeout') ?? config('docker.timeout')
            ));
        });

        $this->app->alias('docker', Docker::class);
    }

    /**
     * 获取提供器提供的服务。
     *
     * @return array
     */
    public function provides()
    {
        return ['docker'];
    }
}
