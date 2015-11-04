<?php
/**
 *
 */

namespace Mvc5\Mvc\Route;

use Mvc5\Route\Route;

interface Dispatch
{
    /**
     * @param Route $route
     * @return Route
     */
    function __invoke(Route $route);
}
