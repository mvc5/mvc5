<?php
/**
 *
 */

namespace Mvc5\Route\Match\Hostname;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Route;

class Hostname
    implements MatchHostname
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
