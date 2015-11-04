<?php
/**
 *
 */

namespace Mvc5\Route\Filter;

use Mvc5\Route\Route;

class Filter
    implements FilterRoute
{
    /**
     * @param Route $route
     */
    public function __invoke(Route $route)
    {
        $route->set(Route::PATH, urldecode($route->path()) ?: '/');
    }
}
