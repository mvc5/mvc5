<?php
/**
 *
 */

namespace Mvc5\Route\Manager;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Exception\RouteException;
use Mvc5\Route\Route;
use Throwable;

interface RouteManager
{
    /**
     * @param array|Definition $definition
     * @return Definition
     */
    function definition($definition);

    /**
     * @param Route $route
     * @param Throwable $exception
     * @return RouteException
     */
    function exception(Route $route, Throwable $exception);

    /**
     * @param Definition $definition
     * @param Route $route
     * @return Route
     */
    function match(Definition $definition, Route $route);

    /**
     * @param Route $route
     * @param array $args
     * @return Route
     */
    function route(Route $route, array $args = []);
}
