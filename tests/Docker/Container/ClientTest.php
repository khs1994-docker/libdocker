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
    public $client;

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

    /**
     * @throws \Exception
     */
    public function testCreate()
    {
        $output = $this->client
            ->setImage('khs1994/nginx:1.15.3-alpine')
            ->setEnv(['a=1'])
            ->setBinds(['/c:/c'])
            ->setPortBindings([
                '80/tcp' => [
                    [
                        'HostIp' => '',
                        'HostPort' => '80',
                    ],
                ],
            ])
            ->setLabels(['a' => '1'])
            ->create()
            ->start(null);

        $this->assertStringMatchesFormat('%s', $output);

        return $output;
    }

    /**
     * @depends testCreate
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testInspect(string $id): void
    {
        $output = $this->client->inspect($id);

        $this->assertJson($output);
    }

    /**
     * @depends testCreate
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testTop(string $id): void
    {
        $output = $this->client->top($id);

        $this->assertJson($output);
    }

    /**
     * @depends testCreate
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testLog(string $id): void
    {
        $output = $this->client->logs($id);

        $this->assertStringMatchesFormat('%S', $output);
    }

    /**
     * @depends testCreate
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testChange(string $id): void
    {
        $output = $this->client->changes($id);

        $this->assertJson($output);
    }

    /**
     * @depends testCreate
     *
     * @param string $id
     *
     * @return string
     *
     * @throws \Exception
     */
    public function testStop(string $id)
    {
        $output = $this->client->stop($id);

        $this->assertNull($output);

        return $id;
    }

    /**
     * @depends testStop
     *
     * @param string $id
     *
     * @return string
     *
     * @throws \Exception
     */
    public function testRestart(string $id)
    {
        $output = $this->client->restart($id);

        $this->assertNull($output);

        return $id;
    }

    /**
     * @depends testRestart
     *
     * @param string $id
     *
     * @return string
     *
     * @throws \Exception
     */
    public function testKill(string $id)
    {
        $output = $this->client->kill($id);

        $this->assertNull($output);

        return $id;
    }

    /**
     * @depends testKill
     *
     * @param string $id
     *
     * @return string
     *
     * @throws \Exception
     */
    public function testStart(string $id)
    {
        $output = $this->client->start($id);

        $this->assertStringMatchesFormat('%s', $output);

        return $id;
    }

    /**
     * @depends testStart
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testUpdate(string $id): void
    {
        $output = $this->client->update($id);

        $this->assertJson($output);
    }

    /**
     * @depends testCreate
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testRename(string $id): void
    {
        $output = $this->client->rename($id, 'my-new-name');

        $this->assertNull($output);
    }

    /**
     * @depends testRestart
     *
     * @param string $id
     *
     * @return string
     *
     * @throws \Exception
     */
    public function testPause(string $id)
    {
        $output = $this->client->pause($id);

        $this->assertNull($output);

        return $id;
    }

    /**
     * @depends testPause
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testUnPause(string $id): void
    {
        $output = $this->client->unpause($id);

        $this->assertNull($output);
    }

    /**
     * @group   no-test
     *
     * @depends testCreate
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testAttach(string $id): void
    {
        $output = $this->client->attach($id);

        $this->assertJson($output);
    }

    /**
     * @group   no-test
     *
     * @depends testCreate
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testAttachViaWebsocket(string $id): void
    {
        $output = $this->client->attachViaWebSocket($id);

        $this->assertJson($output);
    }

    /**
     * @group   no-test
     *
     * @depends testRestart
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testWait(string $id): void
    {
        $output = $this->client->wait($id);

        $this->assertJson($output);
    }

    /**
     * @depends testCreate
     *
     * @param string $id
     *
     * @return string
     *
     * @throws \Exception
     */
    public function testArchive(string $id)
    {
        $output = $this->client->archive($id, '/etc/nginx/nginx.conf');

        $this->assertStringMatchesFormat('%a', $output);

        file_put_contents('archive.tar', $output);

        return $id;
    }

    /**
     * @depends testCreate
     *
     * @group   no-test
     *
     * @param string $id
     *
     * @return string
     *
     * @throws \Exception
     */
    public function testExtract(string $id)
    {
        // $request = file_get_contents('archive.tar');

        $request = 'string';

        $output = $this->client->extract($id, '/etc/nginx', false, $request);

        $this->assertNull($output);

        return $id;
    }

    /**
     * @depends testExtract
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testGetFileInfo(string $id): void
    {
        $output = $this->client->getFileInfo($id, '/etc/nginx/nginx.conf.extract');

        $this->assertStringMatchesFormat('%s', $output);
    }

    /**
     * @depends testStop
     *
     * @param string $id
     *
     * @throws \Exception
     */
    public function testRemove(string $id): void
    {
        $output = $this->client->remove($id, false, true);

        $this->assertNull($output);
    }

    /**
     * @depends testStop
     *
     * @throws \Exception
     */
    public function testPrune(): void
    {
        $output = $this->client->prune();

        $this->assertJson($output);
    }
}
