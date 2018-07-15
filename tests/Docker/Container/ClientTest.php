<?php

declare(strict_types=1);

namespace Docker\Tests\Container;

use Docker\Container\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp(): void
    {
        $this->client = $this->mockApiClient()->container;
    }

    /**
     * @throws \Exception
     */
    public function testList(): void
    {
        $output = $this->client->list();

        $this->assertJson($output);
    }
}
