<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\Forbidden;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

class CSRFToken
{
    /**
     * @var bool
     */
    protected $enable = false;

    /**
     * @param bool $enable
     */
    function __construct(bool $enable = false)
    {
        $this->enable = $enable;
    }

    /**
     * @param string $method
     * @return bool
     */
    protected function allowed(string $method) : bool
    {
        return in_array($method, ['GET', 'HEAD', 'OPTIONS', 'TRACE']);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function match(Request $request) : bool
    {
        return hash_equals($this->param($request), (string) $request[Arg::SESSION][Arg::CSRF_TOKEN]);
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function param(Request $request) : string
    {
        return (string) ($request[Arg::DATA][Arg::CSRF_TOKEN] ?? $request[Arg::HEADERS]['X-CSRF-Token'] ?? '');
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Forbidden|Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return !($route[ARG::CSRF_TOKEN] ?? $this->enable) || $this->allowed($request->method()) || $this->match($request) ?
            $next($route, $request) : new Forbidden;
    }
}
