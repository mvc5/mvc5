<?php
/**
 *
 */

namespace Mvc5\Response;

class Send
{
    /**
     * @param Response $response
     * @return mixed
     */
    public function __invoke(Response $response)
    {
        $response->send();
    }
}
