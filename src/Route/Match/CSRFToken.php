<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\Forbidden;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function hash_equals;
use function in_array;

use const Mvc5\{ CSRF_TOKEN, DATA, HEADERS, HTTP_GET, HTTP_HEAD, HTTP_OPTIONS, HTTP_TRACE, SESSION };

final class CSRFToken
{
    /**
     * @var bool
     */
    protected bool $enable = true;

    /**
     * @param bool $enable
     */
    function __construct(bool $enable = true)
    {
        $this->enable = $enable;
    }

    /**
     * @param string $method
     * @return bool
     */
    protected function allow(string $method) : bool
    {
        return in_array($method, [HTTP_GET, HTTP_HEAD, HTTP_OPTIONS, HTTP_TRACE]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function match(Request $request) : bool
    {
        return hash_equals((string) ($request[SESSION][CSRF_TOKEN] ?? ''), $this->param($request));
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function param(Request $request) : string
    {
        return (string) ($request[DATA][CSRF_TOKEN] ?? $request[HEADERS]['X-CSRF-Token'] ?? '');
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Forbidden|Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return !($route[CSRF_TOKEN] ?? $this->enable) || $this->allow($request->method()) || $this->match($request) ?
            $next($route, $request) : new Forbidden;
    }
}
