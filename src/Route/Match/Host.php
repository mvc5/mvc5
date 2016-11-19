<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Http\Error\NotFound;
use Mvc5\Route\Request;
use Mvc5\Route\Route;

class Host
{
    /**
     *
     */
    use Plugin\Optional;
    use Plugin\Params;

    /**
     * @var null|string
     */
    protected $error = NotFound::class;

    /**
     * @param null|string $error
     */
    function __construct($error = null)
    {
        $error && $this->error = $error;
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request|null
     */
    protected function match(Request $request, Route $route)
    {
        return !$route->host() || in_array($request->host(), (array) $route->host()) ? $request : null;
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request|NotFound
     */
    function __invoke(Request $request, Route $route)
    {
        return !$route->host() || $this->match($request, $route) ? $request : (
            $this->optional($route, Arg::HOST) ? null : new $this->error
        );
    }
}
