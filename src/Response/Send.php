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
    public function __invoke(Response $response)
    {
        $response->send();
    }
}
