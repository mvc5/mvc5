<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function array_search;

class Middleware
{
    /**
     * @var string
     */
    protected string $placeholder;

    /**
     * @var callable
     */
    protected $service;

    /**
     * @param callable $service
     * @param string $placeholder
     */
    function __construct(callable $service, string $placeholder = Arg::CONTROLLER)
    {
        $this->placeholder = $placeholder;
        $this->service = $service;
    }

    /**
     * @param callable|mixed $controller
     * @param array|null $middleware
     * @return mixed
     */
    protected function middleware($controller, array $middleware = null)
    {
        return $middleware ? ($this->service)(Arg::HTTP_MIDDLEWARE, [Arg::MIDDLEWARE => $this->stack($controller, $middleware)]) : null;
    }

    /**
     * @param Request $request
     * @param mixed $middleware
     * @return Request
     */
    protected function request(Request $request, $middleware) : Request
    {
        return $middleware ? $request->with(Arg::CONTROLLER, $middleware) : $request;
    }

    /**
     * @param callable|mixed $controller
     * @param array $middleware
     * @return array
     */
    protected function stack($controller, array $middleware) : array
    {
        $controller && (false !== ($key = array_search($this->placeholder, $middleware, true)) ?
            $middleware[$key] = $controller : $middleware[] = $controller);

        return $middleware;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $next($route, $this->request($request, $this->middleware($request[Arg::CONTROLLER], $route[Arg::MIDDLEWARE])));
    }
}
