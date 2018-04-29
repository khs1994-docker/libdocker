<?php

namespace Docker\Config;

use Pimple\Container as ServiceContainer;

class Config extends ServiceContainer
{

    protected $providers = [

    ];
    const TYPE = 'configs';

    const BASE_URL = '/'.self::TYPE;

    use Request;

    // list

    public function create(string $name, array $labels, string $data)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data
        ];

        $url = self::BASE_URL.'/create';

        $request = json_encode($data);

        return $this->request($url, 'post', $request, $this->header);
    }

    // inspect

    // delete

    public function update(string $id,
                           int $version,
                           string $name,
                           array $labels,
                           string $data)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data
        ];

        $url = self::BASE_URL.'/'.$id.'/update'.http_build_query(['version' => $version]);

        $request = json_encode($data);

        return $this->request($url, 'post', $request);
    }

    private function prune()
    {

    }


    private function remove()
    {

    }


}