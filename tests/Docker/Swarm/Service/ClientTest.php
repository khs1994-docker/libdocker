<?php

declare(strict_types=1);

namespace Docker\Tests\Swarm\Service;

use Docker\Swarm\Service\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    public function setUp(): void
    {
        $this->client = $this->mockApiClient()->service;
    }

    /**
     * @group no-test
     *
     * @throws \Exception
     */
    public function testList(): void
    {
        $output = $this->client->list();

        $this->assertJson($output);
    }
}
