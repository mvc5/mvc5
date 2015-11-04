<?php
/**
 *
 */

namespace Mvc5\Route\Exception;

use Mvc5\Route\Route;
use Throwable;

interface CreateException
{
    /**
     * @param Route $route
     * @param Throwable $exception
     * @return RouteException
     */
    function __invoke(Route $route, Throwable $exception);
}
