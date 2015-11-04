<?php
/**
 *
 */

namespace Mvc5\Route\Match\Wildcard;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Route;

interface MatchWildcard
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    function __invoke(Route $route, Definition $definition);
}
