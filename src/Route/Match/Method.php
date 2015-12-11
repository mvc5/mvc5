<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Route\Definition;
use Mvc5\Route\Route;

class Method
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    public function __invoke(Route $route, Definition $definition)
    {
        return !$definition->method() || in_array($route->method(), (array) $definition->method()) ? $route : null;
    }
}
