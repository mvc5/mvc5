<?php
/**
 *
 */

namespace Mvc5\Request\Error;

use Mvc5\Arg;
use Mvc5\Response\Error;

class Status
{
    /**
     * @param array|\ArrayAccess $response
     * @param Error $error
     * @return array|\ArrayAccess
     */
    function __invoke($response, Error $error)
    {
        $response[Arg::STATUS] = $error->status();

        return $response;
    }
}
