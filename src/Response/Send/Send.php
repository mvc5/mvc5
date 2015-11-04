<?php
/**
 *
 */

namespace Mvc5\Response\Send;

use Mvc5\Response\Response;

interface Send
{
    /**
     * @param Response $response
     * @return mixed
     */
    function __invoke(Response $response);
}
