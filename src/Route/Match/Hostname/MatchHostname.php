<?php
/**
 *
 */

namespace Mvc5\Route\Match\Hostname;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Route;

interface MatchHostname
{
    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    function __invoke(Route $route, Definition $definition);
}
