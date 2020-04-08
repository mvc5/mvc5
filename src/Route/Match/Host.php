<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Http\Error\NotFound;
use Mvc5\Http\Request;
use Mvc5\Route\Route;

use function is_string;
use function preg_match;

use const Mvc5\{ DEFAULTS, HOST, PARAMS, REGEX, URI };

final class Host
{
    /**
     *
     */
    use Plugin\Optional;
    use Plugin\Params;

    /**
     * @param Route $route
     * @param Request $request
     * @param array|string $host
     * @param callable $next
     * @return NotFound|Request|mixed
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
     * @return NotFound|Request|null
     */
    protected function name(Route $route, Request $request, string $host, callable $next)
    {
        return $host === $request[URI][HOST] ? $next($route, $request) : $this->notFound($route);
    }

    /**
     * @param Route $route
     * @return NotFound|null
     */
    protected function notFound(Route $route) : ?NotFound
    {
        return $this->optional($route, HOST) ? null : new NotFound;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param array $host
     * @param callable $next
     * @return NotFound|Request|mixed
     */
    protected function regex(Route $route, Request $request, array $host, callable $next)
    {
        if (!preg_match('(\G' . $host[REGEX] . ')', (string) ($request[URI][HOST] ?? ''), $match)) {
            return $this->notFound($route);
        }

        $request = $request->with(PARAMS, $this->params($match, $host[DEFAULTS] ?? []));

        return $next($route, $request);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @param callable $next
     * @return Request|NotFound|mixed
     */
    function __invoke(Route $route, Request $request, callable $next)
    {
        return $this->match($route, $request, $route->host(), $next);
    }
}
