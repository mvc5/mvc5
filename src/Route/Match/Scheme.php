<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\BadRequest;
use Mvc5\Route\Request;
use Mvc5\Route\Route;

class Scheme
{
    /**
     * @param Request $request
     * @param Route $route
     * @return bool
     */
    protected function match(Request $request, Route $route)
    {
        return in_array($request->scheme(), (array) $route->scheme());
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request|BadRequest
     */
    function __invoke(Request $request, Route $route)
    {
        return !$route->scheme() || $this->match($request, $route) ? $request : new BadRequest;
    }
}
