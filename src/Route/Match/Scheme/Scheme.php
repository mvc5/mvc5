<?php
/**
 *
 */

namespace Mvc5\Route\Match\Scheme;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Route;

class Scheme
    implements MatchScheme
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    public function __invoke(Route $route, Definition $definition)
    {
        return !$definition->scheme() || in_array($route->scheme(), (array) $definition->scheme()) ? $route : null;
    }
}
