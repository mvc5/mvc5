<?php
/**
 *
 */

namespace Mvc5\Response\Manager;

use Mvc5\Response\Response;
use Throwable;

interface ResponseManager
{
    /**
     * @param Response $response
     * @param Throwable $exception
     * @return Response
     */
    function exception(Response $response, Throwable $exception);

    /**
     * @param Response $response
     * @return mixed
     */
    function send(Response $response);
}
