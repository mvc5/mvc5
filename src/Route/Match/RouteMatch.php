<?php
/**
 *
 */

namespace Mvc5\Route\Match;

interface RouteMatch
{
    /**
     *
     */
    const ROUTE = 'Route\Match';

    /**
     * @param callable $callable
     * @param array $args
     * @param callable $callback
     * @return mixed
     */
    function __invoke(callable $callable, array $args = [], callable $callback = null);
}
