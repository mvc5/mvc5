<?php
/**
 *
 */

namespace Mvc5\Route\Router;

use Mvc5\Route\Route;

interface MatchRoute
{
    /**
     * @param Route $route
     * @return Route|null
     */
    function __invoke(Route $route);
}
