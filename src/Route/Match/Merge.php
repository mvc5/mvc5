<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Request;
use Mvc5\Route\Route;

class Merge
{
    /**
     * @param Request $request
     * @param Route $route
     * @param null|Route $parent
     * @return Request
     */
    function __invoke(Request $request, Route $route, Route $parent = null)
    {
        if (!$parent) {
            return $request;
        }

        ($options = $parent->options()) &&
            $route[Arg::OPTIONS] = $route->options() + $options;

        ($middleware = $parent[Arg::MIDDLEWARE] ?: []) &&
            $route[Arg::MIDDLEWARE] = array_merge($middleware, $route[Arg::MIDDLEWARE] ?: []);

        return $request;
    }
}
