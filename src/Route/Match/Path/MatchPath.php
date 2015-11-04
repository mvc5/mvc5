<?php
/**
 *
 */

namespace Mvc5\Route\Match\Path;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Route;

interface MatchPath
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    function __invoke(Route $route, Definition $definition);
}
