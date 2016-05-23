<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Response\Status\Status as ResponseStatus;

class Status
{
    /**
     *
     */
    use ResponseStatus;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->status($request, $response));
    }
}
