<?php

declare(strict_types=1);

namespace Docker\Plugin;

class Plugin
{
    const TYPE = 'plugins';

    const BASE_URL = '/'.self::TYPE;

    // list

    // TODO

    public function getPrivileges(string $remote)
    {
        $url = self::BASE_URL.'/privileges?'.http_build_query(['remote' => $remote]);

        return $this->request($url);
    }

    public function install(): void
    {
    }

    public function inspect(string $name)
    {
        $url = self::BASE_URL.'/'.$name.'/json';

        return $this->request($url);
    }

    // remove

    private function delete(): void
    {
    }

    public function enable(string $name, int $timeout = 0): void
    {
    }

    public function disable(string $name): void
    {
    }

    public function upgrade(string $name, string $remote, string $auth, array $requestBody): void
    {
    }

    public function create(string $name, string $requestBody): void
    {
    }

    public function push(string $name): void
    {
    }

    public function config($name, $requestBody): void
    {
    }
}
