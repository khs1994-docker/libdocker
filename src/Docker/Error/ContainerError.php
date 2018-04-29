<?php
/**
 * Created by PhpStorm.
 * User: khs1994
 * Date: 03/02/2018
 * Time: 2:56 PM.
 */

namespace Docker\Error;

use Throwable;

class ContainerError extends \Error
{
    public function __construct(int $code)
    {

    }

}