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
     * @param Route $route
     * @param Request $request
     * @param $host
     * @param callable $next
     * @return NotFound|null|Request
     */
    protected function match(Route $route, Request $request, $host, callable $next)
    {
        return !$host ? $next($route, $request) : (
            is_string($host) ? $this->name($route, $request, $host, $next) :
                $this->regex($route, $request, $host, $next)
        );
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param string $host
     * @param callable $next
     * @return NotFound|null|Request
     */
    protected function name(Route $route, Request $request, string $host, callable $next)
    {
        return $host === $request[Arg::URI][Arg::HOST] ? $next($route, $request) : $this->notFound($route);
    }

    /**
     * @param Route $route
     * @return NotFound|null
     */
    protected function notFound(Route $route)
    {
        return $this->optional($route, Arg::HOST) ? null : new NotFound;
    }

    /**
     * @param $route
     * @param Request $request
     * @param array $host
     * @param callable $next
     * @return NotFound|null|Request
     */
    protected function regex(Route $route, Request $request, array $host, callable $next)
    {
        if (!preg_match('(\G' . $host[Arg::REGEX] . ')', (string) $request[Arg::URI][Arg::HOST], $match)) {
            return $this->notFound($route);
        }

        $request = $request->with(Arg::PARAMS, $this->params($match, $host[Arg::DEFAULTS] ?? []));

        return $next($route, $request);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|NotFound
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($route, $request, $route->host(), $next);
    }
}
