<?php
/**
 *
 */

namespace Mvc5\Route\Router;

interface RouteDispatch
{
    /**
     *
     */
    const DISPATCH = 'Route\Dispatch';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
