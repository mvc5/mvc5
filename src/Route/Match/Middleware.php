<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Plugin;
use Mvc5\Route\Request;
use Mvc5\Route\Route;
use Mvc5\Service\Service;

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
     * @param Service $service
     * @param $placeholder
     */
    function __construct(Service $service, $placeholder = null)
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
    protected function controller($controller, array $middleware = null)
    {
        return $controller && $middleware ? $this->plugin(Arg::MIDDLEWARE, [$this->stack($controller, $middleware)]) : null;
    }

    /**
     * @param $controller
     * @param array|null $middleware
     * @return callable|mixed|null|object
     */
    protected function stack($controller, array $middleware)
    {
        (false !== ($key = array_search($this->placeholder, $middleware, true))) ?
            $middleware[$key] = $controller : $middleware[] = $controller;

        return $middleware;
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        ($controller = $this->controller($request->controller(), $route[Arg::MIDDLEWARE]))
            && $request[Arg::CONTROLLER] = $controller;

        return $request;
    }
}
