<?php
/**
 *
 */

namespace Mvc5\Route\Error;

use Mvc5\Response\Response;
use Mvc5\Response\Error;

class Status
{
    /**
     * @param Response $response
     * @param Error $error
     * @return mixed
     */
    public function __invoke(Response $response, Error $error)
    {
        $response->setStatus($error->status());
    }
}
