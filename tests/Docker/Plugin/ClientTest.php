<?php

declare(strict_types=1);

namespace Docker\Tests\Plugin;

use Docker\Plugin\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    protected function setUp(): void
    {
        $this->client = $this->mockApiClient()->plugin;
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
