<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\MethodNotAllowed;
use Mvc5\Request\Request;
use Mvc5\Route\Route;

class Method
{
    /**
     *
     */
    use Plugin\Optional;

    /**
     * @param Request $request
     * @param Route $route
     * @return bool
     */
    protected function match(Request $request, Route $route)
    {
        return in_array($request->method(), (array) $route->method());
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|MethodNotAllowed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return !$route->method() || $this->match($request, $route) ? $next($route, $request) : (
            $this->optional($route, Arg::METHOD) ? null : new MethodNotAllowed
        );
    }
}
