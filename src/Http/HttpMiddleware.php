<?php
/**
 *
 */

namespace Mvc5\Http;

use Mvc5\Service\Middleware;

class HttpMiddleware
{
    /**
     *
     */
    use Middleware;

    /**
     * @param Request $request
     * @param Response $response
     * @return Response|mixed
     */
    function __invoke(Request $request, Response $response)
    {
        return $this->call($this->rewind(), [$request, $response]);
    }
}
