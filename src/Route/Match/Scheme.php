<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\BadRequest;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function in_array;

use const Mvc5\{ SCHEME, URI };

class Scheme
{
    /**
     * @param Request $request
     * @param array $scheme
     * @return bool
     */
    protected function match(Request $request, array $scheme) : bool
    {
        return !$scheme || in_array($request[URI][SCHEME], $scheme);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|BadRequest|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($request, (array) $route->scheme()) ? $next($route, $request) : new BadRequest;
    }
}
