<?php

declare(strict_types=1);

namespace Docker\Task;

class Task
{
    const TYPE = 'tasks';

    // list

    // inspect

    private function create(): void
    {
    }

    private function prune(): void
    {
    }

    private function remove(): void
    {
    }

    private function delete(): void
    {
    }

    public function getLog(string $id,
                           bool $details = false,
                           bool $follow = false,
                           bool $stdout = false,
                           bool $stderr = false,
                           int $since = 0,
                           bool $timestamps = false,
                           string $tail = 'all')
    {
        $data = [
            'details' => $details,
            'follow' => $follow,
            'stdout' => $stdout,
            'stderr' => $stderr,
            'since' => $since,
            'timestamps' => $timestamps,
            'tail' => $tail,
        ];

        $url = '/'.self::TYPE.'/'.$id.'/logs?'.http_build_query($data);

        return $this->request($url);
    }
}
