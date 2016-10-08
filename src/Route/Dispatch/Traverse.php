<?php
/**
 *
 */

namespace Mvc5\Route\Dispatch;

use Mvc5\Arg;
use Mvc5\Http\Error\NotFound;
use Mvc5\Http\Request;
use Mvc5\Route\Route;
use Mvc5\Route\Request as RouteRequest;

trait Traverse
{
    /**
     * @param RouteRequest $request
     * @param $name
     * @param $route
     * @param array $routes
     * @return Request|NotFound|null
     */
    protected function iterate(RouteRequest $request, $name, $route, $routes)
    {
        return null === $name ? new NotFound : $this->step($request, $name, $this->routeDefinition($route), $routes);
    }

    /**
     * @param array|\Iterator $routes
     * @return string
     */
    protected function key($routes)
    {
        return is_array($routes) ? key($routes) : $routes->key();
    }

    /**
     * @param RouteRequest $request
     * @param Route $route
     * @param string $name
     * @return Request
     */
    protected function next(RouteRequest $request, Route $route, $name)
    {
        return $this->route(
            $request->with(Arg::NAME, $this->name(is_string($name) ? $name : $route->name(), $request->name())), $route
        );
    }

    /**
     * @param RouteRequest $request
     * @param Route $route
     * @return Request
     */
    protected abstract function route(RouteRequest $request, Route $route);

    /**
     * @param array|Route $route
     * @return Route
     */
    protected abstract function routeDefinition($route);

    /**
     * @param array|\Iterator $routes
     * @return mixed
     */
    protected function shift(&$routes)
    {
        return is_array($routes) ? array_shift($routes) : (
            ($current = $routes->current()) && $routes->next() || true ? $current : null
        );
    }

    /**
     * @param RouteRequest $request
     * @param $name
     * @param $route
     * @param array $routes
     * @return Request
     */
    protected function step(RouteRequest $request, $name, $route, $routes)
    {
        return $this->next($request, $route, $name) ?: $this->traverse($request, $routes);
    }

    /**
     * @param RouteRequest $request
     * @param array $routes
     * @return Request
     */
    protected function traverse(RouteRequest $request, $routes)
    {
        return $this->iterate($request, $this->key($routes), $this->shift($routes), $routes);
    }
}
