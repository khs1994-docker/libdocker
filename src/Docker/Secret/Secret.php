<?php

declare(strict_types=1);

namespace Docker\Secret;

class Secret
{
    const TYPE = 'secrets';

    const BASE_URL = '/'.self::TYPE;

    // list

    public function create(string $name, array $labels, string $data, array $drive)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
            'Drive' => $drive,
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
                           string $data,
                           array $drive)
    {
        $data = [
            'Name' => $name,
            'Labels' => $labels,
            'Data' => $data,
            'Drive' => $drive,
        ];

        $url = self::BASE_URL.'/'.$id.'/update?'.http_build_query(['version' => $version]);

        $request = json_encode($data);

        return $this->request($url, 'post', $request, $this->header);
    }

    private function prune(): void
    {
    }

    private function remove(): void
    {
    }
}
