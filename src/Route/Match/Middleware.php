<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

class Middleware
{
    /**
     * @var string
     */
    protected $placeholder;

    /**
     * @var callable
     */
    protected $service;

    /**
     * @param callable $service
     * @param $placeholder
     */
    function __construct(callable $service, $placeholder = Arg::CONTROLLER)
    {
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
        return $middleware ? ($this->service)(Arg::HTTP_MIDDLEWARE, [Arg::STACK => $this->stack($controller, $middleware)]) : null;
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
        ($middleware = $this->middleware($request[Arg::CONTROLLER], $route[Arg::MIDDLEWARE])) &&
            $request = $request->with(Arg::CONTROLLER, $middleware);

        return $next($route, $request);
    }
}
