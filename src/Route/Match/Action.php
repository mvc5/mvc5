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
     * @param string $method
     * @return mixed
     */
    protected function action(Route $route, string $method)
    {
        return Arg::HTTP_HEAD !== $method ? $route->action($method) :
            $route->action(Arg::HTTP_HEAD) ?? $route->action(Arg::HTTP_GET);
    }

    /**
     * @param Request $request
     * @param $controller
     * @return Request
     */
    protected function request(Request $request, $controller) : Request
    {
        return $controller ? $request->with(Arg::CONTROLLER, $controller) : $request;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $next($route, $this->request($request, $this->action($route, $request->method())));
    }
}
