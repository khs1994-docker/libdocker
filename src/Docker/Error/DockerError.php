<?php

namespace Docker\Error;

class DockerError
{
    public static function returnJSON(int $code, string $message)
    {
        header('content-type:application/json;charset=utf-8');

        return json_encode([
            'return' => $code,
            'message' => $message,
            'time' => time(),
            'data' => date('Y-m-d H:i:s')
        ]);
    }
}