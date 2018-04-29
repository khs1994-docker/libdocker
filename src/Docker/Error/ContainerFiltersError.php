<?php

namespace Docker\Error;

use Docker\Module\Container;

class ContainerFiltersError extends \Error
{
    protected $message;

    protected $code;

    public function __construct(int $code, string $filter)
    {
        $this->code = $code;
        $filters_json = json_encode(Container::$filters_array);
        switch ($code) {
            case 20001:
                $message = "Invalid Container Filter $filter, Available is $filters_json";
                break;
            default:
                $message = null;
        }
        $this->message = $message;
    }

    public function __toString()
    {
        return DockerError::returnJSON($this->code, $this->message);
    }
}