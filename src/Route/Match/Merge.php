<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function array_merge;

class Merge
{
    /**
     * @param Route $route
     * @param Route $parent
     * @param array $config
     * @return Route
     */
    protected function merge(Route $route, Route $parent, array $config = []) : Route
    {
        ($options = $parent->options()) &&
            $config[Arg::OPTIONS] = $route->options() + $options;

        ($middleware = $parent[Arg::MIDDLEWARE]) &&
            $config[Arg::MIDDLEWARE] = array_merge($middleware, $route[Arg::MIDDLEWARE] ?? []);

        !isset($route[Arg::CSRF_TOKEN]) && isset($parent[Arg::CSRF_TOKEN]) &&
            $config[Arg::CSRF_TOKEN] = $parent[Arg::CSRF_TOKEN];

        !isset($route[Arg::AUTHENTICATE]) && isset($parent[Arg::AUTHENTICATE]) &&
            $config[Arg::AUTHENTICATE] = $parent[Arg::AUTHENTICATE];

        return $config ? $route->with($config) : $route;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $next($route[Arg::PARENT] ? $this->merge($route, $route[Arg::PARENT]) : $route, $request);
    }
}
