<?php
/**
 *
 */

namespace Mvc5\Route\Error;

use Mvc5\Response\Error;
use Mvc5\Response\Error\NotFound;

class Handler
{
    /**
     * @param Error $error
     * @return mixed
     */
    public function __invoke(Error $error = null)
    {
        return $error ?? new NotFound;
    }
}
