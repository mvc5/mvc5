<?php
/**
 *
 */

namespace Mvc5\Response;

use Mvc5\Arg;

class Controller
{
    /**
     * @param array|\ArrayAccess $response
     * @param $model
     * @return array|\ArrayAccess
     */
    function __invoke($response, $model)
    {
        $response[Arg::BODY] = $model;

        return $response;
    }
}
