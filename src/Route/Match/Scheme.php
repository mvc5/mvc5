<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Route\Route;
use Mvc5\Response\Error\BadRequest;
use Mvc5\Route\Request;

class Scheme
{
    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        return !$route->scheme() || in_array($request->scheme(), (array) $route->scheme())
            ? $request : new BadRequest;
    }
}
