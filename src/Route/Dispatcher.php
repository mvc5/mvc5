<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;

trait Dispatcher
{
    /**
     * @param array|callable|object|string $name
     * @param array $args
     * @param callable $callback
     * @return callable|mixed|null|object
     */
    protected abstract function call($name, array $args = [], callable $callback = null);

    /**
     * @param array|Route $route
     * @return Route
     */
    protected function definition($route)
    {
        return $this->call(Arg::ROUTE_GENERATOR, [Arg::ROUTE => $route]);
    }

    /**
     * @param $route
     * @param $request
     * @return Request
     */
    protected function match($route, $request)
    {
        return $this->trigger([Arg::ROUTE_MATCH, Arg::ROUTE => $route, Arg::REQUEST => $request]);
    }

    /**
     * @param $request
     * @param array $args
     * @return Request
     */
    protected function route($request, array $args = [])
    {
        return $this->call(Arg::ROUTE_DISPATCH, [Arg::REQUEST => $request] + $args);
    }

    /**
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected abstract function trigger($event, array $args = [], callable $callback = null);
}
