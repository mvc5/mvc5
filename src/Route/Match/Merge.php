<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
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
     * @param null|Route $parent
     * @return Route
     */
    function __invoke(Route $route, Route $parent = null)
    {
        return $parent ? $this->merge($route, $parent) : $route;
    }
}
