<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;
use Throwable;

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
     * @param array|Definition $definition
     * @return Definition
     */
    protected function definition($definition)
    {
        return $this->call(Arg::ROUTE_GENERATOR, [Arg::DEFINITION => $definition]);
    }

    /**
     * @param Throwable $exception
     * @param $route
     * @return mixed
     */
    protected function exception(Throwable $exception, $route)
    {
        return $this->call(Arg::ROUTE_EXCEPTION, [Arg::EXCEPTION => $exception, Arg::ROUTE => $route]);
    }

    /**
     * @param $definition
     * @param $route
     * @return Route
     */
    protected function match($definition, $route)
    {
        return $this->trigger([Arg::ROUTE_MATCH, Arg::DEFINITION => $definition, Arg::ROUTE => $route]);
    }

    /**
     * @param $route
     * @param array $args
     * @return Route
     */
    protected function route($route, array $args = [])
    {
        return $this->call(Arg::ROUTE_DISPATCH, [Arg::ROUTE => $route] + $args);
    }

    /**
     * @param array|object|string|\Traversable $event
     * @param array $args
     * @param callable $callback
     * @return mixed|null
     */
    protected abstract function trigger($event, array $args = [], callable $callback = null);
}
