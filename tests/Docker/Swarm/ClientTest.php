<?php

declare(strict_types=1);

namespace Docker\Tests\Swarm;

use Docker\Swarm\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    public function setUp(): void
    {
        $this->client = $this->mockApiClient()->swarm;
    }

    /**
     * @group no-test
     *
     * @throws \Exception
     */
    public function testInitialize(): void
    {
        $output = $this->client->initialize();

        $this->assertJson($output);
    }
}
