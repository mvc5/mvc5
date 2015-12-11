<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Route\Definition;
use Mvc5\Route\Route;

class Hostname
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    public function __invoke(Route $route, Definition $definition)
    {
        return !$definition->hostname() || in_array($route->hostname(), (array) $definition->hostname()) ? $route : null;
    }
}
