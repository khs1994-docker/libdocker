<?php

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

    public function install()
    {

    }

    public function inspect(string $name)
    {
        $url = self::BASE_URL.'/'.$name.'/json';
        return $this->request($url);
    }

    // remove

    private function delete()
    {

    }

    public function enable(string $name, int $timeout = 0)
    {

    }

    public function disable(string $name)
    {

    }

    public function upgrade(string $name, string $remote, string $auth, array $requestBody)
    {

    }

    public function create(string $name, string $requestBody)
    {

    }

    public function push(string $name)
    {

    }

    public function config($name, $requestBody)
    {

    }
}
