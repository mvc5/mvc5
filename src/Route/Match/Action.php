<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Route\Request;

class Action
{
    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        if (!$route->actions()) {
            return $request;
        }

        ($controller = $route->action($request->method())) &&
            $request[Arg::CONTROLLER] = $controller;

        return $request;
    }
}
