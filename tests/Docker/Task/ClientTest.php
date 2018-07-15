<?php

declare(strict_types=1);

namespace Docker\Tests\Task;

use Docker\Task\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    public function setUp(): void
    {
        $this->client = $this->mockApiClient()->task;
    }

    /**
     * @throws \Exception
     */
    public function test(): void
    {
        $output = $this->client->list();

        $this->assertStringMatchesFormat('%s', $output);
    }
}
