<?php

declare(strict_types=1);

namespace Docker\Swarm\Node;

class Node
{
    const BASE_URL = '/nodes';

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
            'Availability' => $availability,
        ];
        $url = self::BASE_URL.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        return $this->request($url, 'post', json_encode($data));
    }

    private function create(): void
    {
    }

    private function remove(): void
    {
    }

    private function prune(): void
    {
    }
}
