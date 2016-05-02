<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Definition;
use Mvc5\Route\Route;

class Action
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    function __invoke(Route $route, Definition $definition)
    {
        if (!$definition->actions()) {
            return $route;
        }

        ($controller = $definition->action($route->method())) &&
            $route[Arg::CONTROLLER] = $controller;

        return $route;
    }
}
