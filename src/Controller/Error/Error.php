<?php
/**
 *
 */

namespace Mvc5\Controller\Error;

use Mvc5\Response\Response;

interface Error
{
    /**
     * @param Response $response
     * @return ErrorModel
     */
    function __invoke(Response $response);
}
