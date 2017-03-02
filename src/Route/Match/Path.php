<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Request\Request;
use Mvc5\Route\Route;

class Path
{
    /**
     *
     */
    use Plugin\Params;

    /**
     * @param Route $route
     * @param Request $request
     * @param int $offset
     * @return Request
     */
    protected function match(Route $route, Request $request, $offset)
    {
        if (!preg_match('(\G' . $route->regex() . ')', $request->path(), $match, null, $offset ?? 0)) {
            return null;
        }

        $offset += strlen($match[0]);

        $request[Arg::CONTROLLER] = $route->controller();
        $request[Arg::MATCHED] = $offset;
        $request[Arg::PARAMS] = $this->params($match, $route->defaults() + $request->params());
        $request[Arg::ROUTE] = $offset == strlen($request->path()) ? $route : null;

        return $request;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        $request = $this->match($route, $request, $request[Arg::MATCHED]);

        return is_null($request) ? null : ($request->route() ? $next($route, $request) : $request);
    }
}
