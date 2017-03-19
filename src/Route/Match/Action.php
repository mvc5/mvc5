<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

class Action
{
    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        $route->actions()
            && ($controller = $route->action($request->method()))
                && $request[Arg::CONTROLLER] = $controller;

        return $next($route, $request);
    }
}
