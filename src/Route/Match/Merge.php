<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Request;
use Mvc5\Route\Route;

use const Mvc5\{ AUTHENTICATE, CSRF_TOKEN, MIDDLEWARE, OPTIONS, PARENT };

final class Merge
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
            $config[OPTIONS] = $route->options() + $options;

        ($middleware = $parent[MIDDLEWARE]) &&
            $config[MIDDLEWARE] = [...$middleware, ...($route[MIDDLEWARE] ?? [])];

        !isset($route[CSRF_TOKEN]) && isset($parent[CSRF_TOKEN]) &&
            $config[CSRF_TOKEN] = $parent[CSRF_TOKEN];

        !isset($route[AUTHENTICATE]) && isset($parent[AUTHENTICATE]) &&
            $config[AUTHENTICATE] = $parent[AUTHENTICATE];

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
        return $next($route[PARENT] ? $this->merge($route, $route[PARENT]) : $route, $request);
    }
}
