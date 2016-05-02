<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Route\Definition;
use Mvc5\Response\Error\BadRequest;
use Mvc5\Route\Route;

class Scheme
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    function __invoke(Route $route, Definition $definition)
    {
        return !$definition->scheme() || in_array($route->scheme(), (array) $definition->scheme())
            ? $route : new BadRequest;
    }
}
