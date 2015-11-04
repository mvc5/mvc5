<?php
/**
 *
 */

namespace Mvc5\Response\Exception;

use Mvc5\Response\Response;

interface Dispatch
{
    /**
     * @param Response $response
     * @return Response
     */
    function __invoke(Response $response);
}
