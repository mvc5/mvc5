<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Plugins\Service;
use Mvc5\Route\Request;
use Mvc5\Route\Route;

class Middleware
{
    /**
     *
     */
    use Service;

    /**
     *
     */
    const CONTROLLER_ACTION = 'controller\action';

    /**
     *
     */
    const CONTROLLER_MIDDLEWARE = 'controller\middleware';

    /**
     * @param $controller
     * @param array|null $middleware
     * @return callable|mixed|null|object
     */
    protected function middleware($controller, array $middleware = null)
    {
        return $controller && $middleware
            ? $this->plugin(static::CONTROLLER_MIDDLEWARE, [$controller, $this->stack($middleware)]) : null;
    }

    /**
     * @param $middleware
     * @return array
     */
    protected function stack($middleware)
    {
        !in_array(static::CONTROLLER_ACTION, $middleware) &&
            $middleware[] = static::CONTROLLER_ACTION;

        return $middleware;
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        ($middleware = $this->middleware($request->controller(), $route[Arg::MIDDLEWARE]))
            && $request[Arg::CONTROLLER] = $middleware;

        return $request;
    }
}
