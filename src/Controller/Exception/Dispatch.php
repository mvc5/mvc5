<?php
/**
 *
 */

namespace Mvc5\Controller\Exception;

use Mvc5\Response\Response;
use Throwable;

interface Dispatch
{
    /**
     * @param Throwable $exception
     * @param Response $response
     * @return mixed
     */
    function __invoke(Throwable $exception, Response $response);
}
