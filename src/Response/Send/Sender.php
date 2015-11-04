<?php
/**
 *
 */

namespace Mvc5\Response\Send;

use Mvc5\Response\Response;

class Sender
    implements Send
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
