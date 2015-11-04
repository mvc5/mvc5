<?php
/**
 *
 */

namespace Mvc5\Route\Filter;

use Mvc5\Route\Route;

interface FilterRoute
{
    /**
     * @param Route $route
     * @return void
     */
    function __invoke(Route $route);
}
