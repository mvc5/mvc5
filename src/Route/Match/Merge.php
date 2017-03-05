<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Request\Request;
use Mvc5\Route\Route;

class Merge
{
    /**
     * @param Route $route
     * @param Route $parent
     * @return Route
     */
    protected function merge(Route $route, Route $parent)
    {
        ($options = $parent->options()) &&
            $route[Arg::OPTIONS] = $route->options() + $options;

        ($middleware = $parent[Arg::MIDDLEWARE]) &&
            $route[Arg::MIDDLEWARE] = array_merge($middleware, $route[Arg::MIDDLEWARE] ?: []);

        return $route;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $next($route[Arg::PARENT] ? $this->merge($route, $route[Arg::PARENT]) : $route, $request);
    }
}
