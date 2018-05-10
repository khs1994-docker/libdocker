<?php

declare(strict_types=1);
//require __DIR__.'/../../vendor/autoload.php';

use Docker\Docker;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    const DOCKER_HOST = '127.0.0.1:2375';

    const DOCKER_TLS_VERIFY = 1;

    const DOCKER_CERT_PATH = __DIR__.'/ssl';

    public $image;

    public function setup(): void
    {
        $docker = Docker::docker();
        $this->image = $docker->image();
    }

    // 拉取镜像

    public function testPull(): void
    {
        var_dump($this->image->pull('nginx', '1.13.8-alpine'));
    }

    public function testList(): void
    {
        $this->image->list();
    }
}
