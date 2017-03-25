<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\NotFound;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

class Host
{
    /**
     *
     */
    use Plugin\Optional;
    use Plugin\Params;

    /**
     * @param Request $request
     * @param $host
     * @return Request|null
     */
    protected function match(Request $request, $host)
    {
        return !$host || in_array($request[Arg::URI][Arg::HOST], (array) $host) ? $request : null;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|NotFound
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($request, $route->host()) ? $next($route, $request) : (
            $this->optional($route, Arg::HOST) ? null : new NotFound
        );
    }
}
