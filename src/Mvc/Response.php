<?php
/**
 *
 */

namespace Mvc5\Mvc;

class Response
{
    /**
     * @param $response
     * @return mixed
     */
    public function __invoke($response)
    {
        return $response;
    }
}
