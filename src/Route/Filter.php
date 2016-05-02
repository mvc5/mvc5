<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Arg;

class Filter
{
    /**
     * @param Route $route
     */
    function __invoke(Route $route)
    {
        $route[Arg::PATH] = urldecode($route->path()) ?: Arg::SEPARATOR;
    }
}
