<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\BadRequest;
use Mvc5\Route\Request;
use Mvc5\Route\Route;

class Host
{
    /**
     * @param Request $request
     * @param Route $route
     * @return Request|BadRequest
     */
    function __invoke(Request $request, Route $route)
    {
        return !$route->host() || in_array($request->host(), (array) $route->host()) ? $request : new BadRequest;
    }
}
