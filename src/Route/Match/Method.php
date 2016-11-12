<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\MethodNotAllowed;
use Mvc5\Route\Request;
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
     * @param Request $request
     * @param Route $route
     * @return Request|MethodNotAllowed
     */
    function __invoke(Request $request, Route $route)
    {
        return !$route->method() || $this->match($request, $route) ? $request : (
            $this->optional($route, Arg::METHOD) ? null : new MethodNotAllowed
        );
    }
}
