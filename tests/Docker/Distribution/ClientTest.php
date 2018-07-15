<?php

declare(strict_types=1);

namespace Docker\Tests\Distribution;

use Docker\Distribution\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    public function setUp(): void
    {
        $this->client = $this->mockApiClient()->distribution;
    }

    /**
     * @throws \Exception
     */
    public function testInfo(): void
    {
        $output = $this->client->info('khs1994/nginx');

        $this->assertArrayHasKey('Descriptor', json_decode($output, true));
    }
}
