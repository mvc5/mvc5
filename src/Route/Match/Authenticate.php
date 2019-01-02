<?php

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\Unauthorized;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

class Authenticate
{
    /**
     * @var string|null
     */
    protected $controller = 'login\redirect';

    /**
     * @param string|null $controller
     */
    function __construct(string $controller = null)
    {
        $controller && $this->controller = $controller;
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function controller(Request $request) : Request
    {
        return $request->with(Arg::CONTROLLER, $this->controller);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function redirect(Request $request) : bool
    {
        return 'GET' === $request[Arg::METHOD] && !$request[Arg::ACCEPTS_JSON];
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Unauthorized|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return !($route[Arg::AUTHENTICATE] ?? false) || ($request[Arg::AUTHENTICATED] ?? false) ?
            $next($route, $request) : ($this->redirect($request) ? $this->controller($request) : new Unauthorized);
    }
}
