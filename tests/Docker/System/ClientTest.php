<?php

declare(strict_types=1);

namespace Docker\Tests\System;

use Docker\System\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    public function setUp(): void
    {
        $this->client = $this->mockApiClient()->system;
    }

    /**
     * @throws \Exception
     */
    public function testArch(): void
    {
        $output = $this->client->arch();

        $this->assertStringMatchesFormat('%s', $output);
    }
}
