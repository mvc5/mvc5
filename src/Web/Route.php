<?php
/**
 *
 */

namespace Mvc5\Web;

use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Plugin;
use Mvc5\Route\Dispatcher;

class Route
{
    /**
     *
     */
    use Dispatcher;
    use Plugin;

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($this->route($request), $response);
    }
}
