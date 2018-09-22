<?php

declare(strict_types=1);

if (!class_exists(\Illuminate\Support\Facades\Facade::class)) {
    return;
}

if (!(function_exists('docker'))) {
    /**
     * @return \Docker\Docker
     */
    function docker()
    {
        return app(Docker\Docker::class);
    }
}

class Docker extends \Docker\Kernel\Facade
{

}
