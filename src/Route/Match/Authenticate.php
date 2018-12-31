<?php

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\Unauthorized;
use Mvc5\Http\Request;
use Mvc5\Response\RedirectResponse;
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
     * @return Unauthorized|RedirectResponse
     */
    protected function unauthorized(Request $request)
    {
        if ('GET' === $request[Arg::METHOD] && !$request[Arg::ACCEPTS_JSON]) {
            $request[Arg::SESSION][Arg::REDIRECT_URL] = $request[Arg::URI];
            return new RedirectResponse($this->url);
        }

        return new Unauthorized;
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
            $next($route, $request) : $this->unauthorized($request);
    }
}
