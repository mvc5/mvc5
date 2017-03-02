<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\NotFound;
use Mvc5\Request\Request;
use Mvc5\Route\Route;

class Host
{
    /**
     *
     */
    use Plugin\Optional;
    use Plugin\Params;

    /**
     * @param Request $request
     * @param Route $route
     * @return Request|null
     */
    protected function match(Request $request, Route $route)
    {
        return !$route->host() || in_array($request->host(), (array) $route->host()) ? $request : null;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|NotFound
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return !$route->host() || $this->match($request, $route) ? $next($route, $request) : (
            $this->optional($route, Arg::HOST) ? null : new NotFound
        );
    }
}
