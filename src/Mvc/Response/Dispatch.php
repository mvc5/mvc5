<?php
/**
 *
 */

namespace Mvc5\Mvc\Response;

use Mvc5\Response\Response;

interface Dispatch
{
    /**
     * @param Response $response
     * @return mixed
     */
    function __invoke(Response $response);
}
