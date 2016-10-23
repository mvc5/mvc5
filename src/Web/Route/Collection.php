<?php
/**
 *
 */

namespace Mvc5\Web\Route;

use Mvc5\Arg;
use Mvc5\Http\Request;
use Mvc5\Http\Response;
use Mvc5\Route\Dispatch\Router;

class Collection
{
    /**
     *
     */
    use Router;

    /**
     * @param $name
     * @param $parent
     * @return string
     */
    protected function name($name, $parent)
    {
        return !$parent ? $name : $parent . Arg::SEPARATOR . $name;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        return $next($this->result($request, $this->traverse($this->routeRequest($request), $this->route)), $response);
    }
}
