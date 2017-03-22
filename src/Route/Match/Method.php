<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\MethodNotAllowed;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

class Method
{
    /**
     *
     */
    use Plugin\Optional;

    /**
     * @param Request $request
     * @param $method
     * @return bool
     */
    protected function match(Request $request, $method)
    {
        return !$method || in_array($request->method(), (array) $method);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|MethodNotAllowed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($request, $route->method()) ? $next($route, $request) : (
            $this->optional($route, Arg::METHOD) ? null : new MethodNotAllowed
        );
    }
}
