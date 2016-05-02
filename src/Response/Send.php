<?php
/**
 *
 */

namespace Mvc5\Response;

class Send
{
    /**
     * @param Response $response
     */
    function __invoke(Response $response)
    {
        $response->send();
    }
}
