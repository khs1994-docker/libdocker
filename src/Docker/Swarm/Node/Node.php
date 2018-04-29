<?php

namespace Docker;

class Node
{
    const BASE_URL = '/nodes';

    use Request;

    // list

    // inspect

    // delete

    public function update(string $id,
                           int $version,
                           string $name,
                           array $labels = null,
                           string $role,
                           string $availability)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Role' => $role,
            'Availability' => $availability
        ];
        $url = self::BASE_URL.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        return $this->request($url, 'post', json_encode($data));
    }


    private function create()
    {
    }


    private function remove()
    {
    }


    private function prune()
    {
    }
}