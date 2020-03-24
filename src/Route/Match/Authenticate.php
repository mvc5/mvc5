<?php

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\Unauthorized;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use const Mvc5\{ AUTHENTICATE, AUTHENTICATED, ACCEPTS_JSON, CONTROLLER, METHOD };

class Authenticate
{
    /**
     * @var string|null
     */
    protected ?string $controller = 'login\redirect';

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
        return $request->with(CONTROLLER, $this->controller);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function redirect(Request $request) : bool
    {
        return 'GET' === $request[METHOD] && !$request[ACCEPTS_JSON];
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Unauthorized|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return !($route[AUTHENTICATE] ?? false) || ($request[AUTHENTICATED] ?? false) ?
            $next($route, $request) : ($this->redirect($request) ? $this->controller($request) : new Unauthorized);
    }
}
