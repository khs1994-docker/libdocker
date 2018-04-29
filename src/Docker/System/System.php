<?php

namespace Docker;

class System
{
    use Request;

    public function checkAuthConfig($username, $password, $email, $serverAddress)
    {
        $url = '/auth';

        $data = [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'serveraddress' => $serverAddress
        ];

        $request = json_encode($data);

        return $this->request($url, 'post', $request, $this->header);

    }

    public function getInfo()
    {
        return $this->request('/info');
    }

    public function getVersion()
    {
        return $this->request('/version');
    }

    public function ping()
    {
        return $this->request('/_ping');
    }

    public function events($since, $until, $filters)
    {
        $filters_array = [];
        if ($filters) {
            $filters_array = $this->resolveFilters($filters);
        }
        $data = [
            'since' => $since,
            'until' => $until,
        ];

        $data = array_merge($data, $filters_array);

        $url = '/events?'.http_build_query($data);

        return $this->request($url);
    }

    public function getDataUsageInfo()
    {
        return $this->request('/system/df');
    }
}