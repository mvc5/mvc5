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
     * @param string|null $method
     * @return mixed
     */
    protected function action(Route $route, ?string $method)
    {
        return !$method ? null : (Arg::HTTP_HEAD !== $method ? $route->action($method) :
            $route->action($method) ?? $route->action(Arg::HTTP_GET));
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        ($controller = $this->action($route, $request->method())) &&
            $request = $request->with(Arg::CONTROLLER, $controller);

        return $next($route, $request);
    }
}
