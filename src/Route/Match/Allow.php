<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Route\Definition;
use Mvc5\Response\Error\MethodNotAllowed;
use Mvc5\Route\Route;

class Allow
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    public function __invoke(Route $route, Definition $definition)
    {
        return !$definition->allow() || in_array($route->method(), (array) $definition->allow())
            ? $route : new MethodNotAllowed;
    }
}
