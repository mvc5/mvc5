<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Response\Version\Version as ResponseVersion;

class Version
{
    /**
     *
     */
    use ResponseVersion;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->version($request, $response));
    }
}
