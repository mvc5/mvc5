<?php
/**
 *
 */

namespace Mvc5\Response\Exception;

use Mvc5\Response\Response;
use Throwable;

interface Render
{
    /**
     * @param Throwable $exception
     * @param Response $response
     * @return Response
     */
    function __invoke(Throwable $exception, Response $response);
}
