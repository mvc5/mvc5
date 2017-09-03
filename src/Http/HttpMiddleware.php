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
     * @param Request|mixed $request
     * @param Response|mixed $response
     * @return Response|mixed
     */
    function __invoke($request, $response)
    {
        return $this->call($this->rewind(), [$request, $response]);
    }
}
