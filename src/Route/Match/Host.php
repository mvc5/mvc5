<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Route\Route;
use Mvc5\Response\Error\BadRequest;
use Mvc5\Route\Request;

class Host
{
    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        return !$route->host() || in_array($request->host(), (array) $route->host()) ? $request : new BadRequest;
    }
}
