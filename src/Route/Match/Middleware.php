<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Plugin;
use Mvc5\Request\Request;
use Mvc5\Route\Route;

class Middleware
{
    /**
     *
     */
    use Plugin;

    /**
     * @var string
     */
    protected $placeholder = Arg::CONTROLLER;

    /**
     * @param callable $service
     * @param $placeholder
     */
    function __construct(callable $service, $placeholder = null)
    {
        $placeholder &&
            $this->placeholder = $placeholder;

        $this->service = $service;
    }

    /**
     * @param $controller
     * @param array|null $middleware
     * @return callable|mixed|null|object
     */
    protected function middleware($controller, array $middleware = null)
    {
        return $middleware ? ($this->service)(Arg::MIDDLEWARE, [$this->stack($controller, $middleware)]) : null;
    }

    /**
     * @param $controller
     * @param array|null $middleware
     * @return callable|mixed|null|object
     */
    protected function stack($controller, array $middleware)
    {
        $controller && (false !== ($key = array_search($this->placeholder, $middleware, true)) ?
            $middleware[$key] = $controller : $middleware[] = $controller);

        return $middleware;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        ($middleware = $this->middleware($request->controller(), $route[Arg::MIDDLEWARE]))
            && $request[Arg::CONTROLLER] = $middleware;

        return $next($route, $request);
    }
}
