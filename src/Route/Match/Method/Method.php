<?php
/**
 *
 */

namespace Mvc5\Route\Match\Method;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Route;

class Method
    implements MatchMethod
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
