<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Request;
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
     * @param string $path
     * @param int $offset
     * @param callable $next
     * @return null|Request
     */
    protected function match(Route $route, Request $request, string $path, int $offset, callable $next)
    {
        if (!preg_match('(\G' . $route->regex() . ')', $path, $match, 0, $offset)) {
            return null;
        }

        $offset += strlen($match[0]);
        $matched = !isset($path[$offset]);

        $request = $request->with([
            Arg::CONTROLLER => $route->controller(),
            Arg::MATCHED => $matched ?: $offset,
            Arg::NAME => $route->name(),
            Arg::PARAMS => $this->params($match, $route->defaults() + (array) $request[Arg::PARAMS]),
            Arg::PARENT => $request,
            Arg::ROUTE => $route
        ]);

        return $matched ? $next($route, $request) : ($route->children() ? $request : null);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($route, $request, $request[Arg::URI][Arg::PATH], (int) $request[Arg::MATCHED], $next);
    }
}
