<?php

declare(strict_types=1);

if (!(function_exists('docker'))) {
    function docker()
    {
        return app(Docker::class);
    }
}

class Docker extends \Docker\Facade
{
}
