<?php

declare(strict_types=1);

namespace Docker\Tests\Swarm\Node;

use Docker\Swarm\Node\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    public function setUp(): void
    {
        $this->client = $this->mockApiClient()->node;
    }

    /**
     * @group no-test
     *
     * @throws \Exception
     */
    public function testList(): void
    {
        $this->client->list();
    }
}
