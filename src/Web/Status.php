<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;

class Status
{
    /**
     *
     */
    use \Mvc5\Response\Service\Status;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->status($request, $response));
    }
}
