<?php

declare(strict_types=1);

namespace Docker\Tests\Image;

use Docker\Image\Client;
use Docker\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    public function setUp(): void
    {
        $this->client = $this->mockApiClient()->image;
    }

    /**
     * @throws \Exception
     */
    public function testPull(): void
    {
        $output = $this->client->pull('nginx', '1.15.1-alpine');
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
