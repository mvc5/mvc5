<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function preg_match;
use function strlen;

use const Mvc5\{ CONTROLLER, MATCHED, NAME, PARAMS, PARENT, PATH, ROUTE, URI };

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
     * @return Request|mixed
     */
    protected function match(Route $route, Request $request, string $path, int $offset, callable $next)
    {
        if (!preg_match('(\G' . $route->regex() . ')', $path, $match, 0, $offset)) {
            return null;
        }

        $offset += strlen($match[0]);
        $matched = !isset($path[$offset]);

        $request = $request->with([
            CONTROLLER => $route->controller(),
            MATCHED => $matched ?: $offset,
            NAME => $route->name(),
            PARAMS => $this->params($match, $route->defaults() + (array) $request[PARAMS]),
            PARENT => $request,
            ROUTE => $route
        ]);

        return $matched ? $next($route, $request) : ($route->children() ? $request : null);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($route, $request, $request[URI][PATH], (int) $request[MATCHED], $next);
    }
}
