<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\MethodNotAllowed;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function in_array;

use const Mvc5\{ HTTP_GET, HTTP_HEAD, METHOD };

final class Method
{
    /**
     *
     */
    use Plugin\Optional;

    /**
     * @param string $method
     * @param array $methods
     * @return bool
     */
    protected function match(string $method, array $methods) : bool
    {
        return !$methods || in_array($method, $methods) || (HTTP_HEAD === $method && in_array(HTTP_GET, $methods));
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return MethodNotAllowed|Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($request->method(), (array) $route->method()) ? $next($route, $request) : (
            $this->optional($route, METHOD) ? null : new MethodNotAllowed
        );
    }
}
