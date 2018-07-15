<?php

declare(strict_types=1);

namespace Docker\Tests;

use Docker\Docker;

class TestCase extends \PHPUnit\Framework\TestCase
{
    const DOCKER_HOST = '127.0.0.1:2375';

    const DOCKER_TLS_VERIFY = 1;

    const DOCKER_CERT_PATH = __DIR__.'/ssl';

    public $client;

    public function mockApiClient()
    {
        return Docker::docker(Docker::createOptionArray('127.0.0.1:2375'));
    }
}
