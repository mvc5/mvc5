<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;

class Version
{
    /**
     *
     */
    use \Mvc5\Response\Version\Version;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return mixed|Response
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($request, $this->version($request, $response));
    }
}
