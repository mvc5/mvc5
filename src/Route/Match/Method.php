<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Route\Route;
use Mvc5\Response\Error\MethodNotAllowed;
use Mvc5\Route\Request;

class Method
{
    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        return !$route->method() || in_array($request->method(), (array) $route->method())
            ? $request : new MethodNotAllowed;
    }
}
