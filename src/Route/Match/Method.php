<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\MethodNotAllowed;
use Mvc5\Route\Request;
use Mvc5\Route\Route;

class Method
{
    /**
     * @param Request $request
     * @param Route $route
     * @return Request|MethodNotAllowed
     */
    function __invoke(Request $request, Route $route)
    {
        return !$route->method() || in_array($request->method(), (array) $route->method())
            ? $request : new MethodNotAllowed;
    }
}
