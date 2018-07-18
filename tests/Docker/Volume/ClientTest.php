<?php

declare(strict_types=1);

namespace Docker\Tests\Volume;

use Docker\Tests\TestCase;
use Docker\Volume\Client;

class ClientTest extends TestCase
{
    /**
     * @var Client;
     */
    public $client;

    public function setUp(): void
    {
        $this->client = $this->client = $this->mockApiClient()->volume;
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
