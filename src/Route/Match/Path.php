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
     * @param callable $next
     * @return Request
     */
    protected function match(Route $route, Request $request, $offset, callable $next)
    {
        if (!preg_match('(\G' . $route->regex() . ')', $request->path(), $match, null, (int) $offset)) {
            return null;
        }

        $offset += strlen($match[0]);
        $matched = $offset == strlen($request->path());

        $request[Arg::CONTROLLER] = $route->controller();
        $request[Arg::MATCHED] = $offset;
        $request[Arg::PARAMS] = $this->params($match, $route->defaults() + $request->params());
        $request[Arg::ROUTE] = $matched ? $route : null;

        return $matched ? $next($route, $request) : $request;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($route, $request, $request[Arg::MATCHED], $next);
    }
}
