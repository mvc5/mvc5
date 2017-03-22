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
     * @param $scheme
     * @return bool
     */
    protected function match(Request $request, $scheme)
    {
        return !$scheme || in_array($request->scheme(), (array) $scheme);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|BadRequest
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($request, $route->scheme()) ? $next($route, $request) : new BadRequest;
    }
}
