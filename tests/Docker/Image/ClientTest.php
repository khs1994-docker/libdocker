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
        $output = $this->client->pull('nginx', '1.15.3-alpine');

        $this->assertStringMatchesFormat('%a', $output);
    }

    /**
     * @throws \Exception
     */
    public function testList(): void
    {
        $output = $this->client->list();

        $this->assertJson($output);
    }

    /**
     * @throws \Exception
     */
    public function testTag(): void
    {
        $output = $this->client->tag('nginx:1.15.3-alpine', 'nginx', 'alpine');

        $this->assertStringMatchesFormat('%S', $output);
    }

    public function test_parseImage(): void
    {
        [$image,$tag] = $this->client->parseImage('khs1994/nginx', 'latest');
        $this->assertEquals('khs1994/nginx', $image);
        $this->assertEquals('latest', $tag);
        [$image,$tag] = $this->client->parseImage('khs1994/nginx:1.15.1-alpine', 'latest');
        $this->assertEquals('khs1994/nginx', $image);
        $this->assertEquals('1.15.1-alpine', $tag);
        [$image,$tag] = $this->client->parseImage('docker.khs1994.com:1000/khs1994/nginx', 'latest');
        $this->assertEquals('docker.khs1994.com:1000/khs1994/nginx', $image);
        $this->assertEquals('latest', $tag);
        [$image,$tag] = $this->client->parseImage('docker.khs1994.com:1000/khs1994/nginx:1.15.1-alpine', 'latest');
        $this->assertEquals('docker.khs1994.com:1000/khs1994/nginx', $image);
        $this->assertEquals('1.15.1-alpine', $tag);
    }
}
