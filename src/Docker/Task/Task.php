<?php

namespace Docker;

class Task
{
    const TYPE = 'tasks';

    use Request;

    // list

    // inspect

    private function create()
    {
    }

    private function prune()
    {
    }


    private function remove()
    {
    }

    private function delete()
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
            'tail' => $tail
        ];

        $url = '/'.self::TYPE.'/'.$id.'/logs?'.http_build_query($data);

        return $this->request($url);
    }

}