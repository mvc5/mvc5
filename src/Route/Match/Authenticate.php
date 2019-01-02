<?php

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\Unauthorized;
use Mvc5\Http\Request;
use Mvc5\Http\HttpRedirect;
use Mvc5\Route\Route;

class Authenticate
{
    /**
     * @var string|null
     */
    protected $url = '/login';

    /**
     * @param string|null $url
     */
    function __construct(string $url = null)
    {
        $url && $this->url = $url;
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function login(Request $request) : bool
    {
        return 'GET' === $request[Arg::METHOD] && !$request[Arg::ACCEPTS_JSON];
    }

    /**
     * @param Request $request
     * @return HttpRedirect
     */
    protected function redirect(Request $request) : HttpRedirect
    {
        $request[Arg::SESSION][Arg::REDIRECT_URL] = $request[Arg::URI];

        return new HttpRedirect($this->url);
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
            $next($route, $request) : ($this->login($request) ? $this->redirect($request) : new Unauthorized);
    }
}
