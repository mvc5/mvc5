<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\MethodNotAllowed;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function in_array;

class Method
{
    /**
     *
     */
    use Plugin\Optional;

    /**
     * @param Request $request
     * @param array $method
     * @return bool
     */
    protected function match(Request $request, array $method) : bool
    {
        return !$method || in_array($request->method(), $method);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return MethodNotAllowed|Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($request, (array) $route->method()) ? $next($route, $request) : (
            $this->optional($route, Arg::METHOD) ? null : new MethodNotAllowed
        );
    }
}
