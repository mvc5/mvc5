<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\BadRequest;
use Mvc5\Request\Request;
use Mvc5\Route\Route;

class Scheme
{
    /**
     * @param Request $request
     * @param Route $route
     * @return bool
     */
    protected function match(Request $request, Route $route)
    {
        return in_array($request->scheme(), (array) $route->scheme());
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|BadRequest
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return !$route->scheme() || $this->match($request, $route) ? $next($route, $request) : new BadRequest;
    }
}
