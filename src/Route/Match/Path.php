<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Route\Request;

class Path
{
    /**
     * @param array $map
     * @param array $matches
     * @param array $defaults
     * @return array
     */
    protected function params(array $map, array $matches, array $defaults = [])
    {
        $matched = [];

        foreach($map as $name => $arg) {
            !empty($matches[$name]) && $matched[$arg] = $matches[$name];
        }

        return $matched + $defaults;
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        if (!preg_match('(\G' . $route->regex() . ')', $request->path(), $matches, null, $request->length())) {
            return null;
        }

        $request[Arg::CONTROLLER] = $route->controller();
        $request[Arg::LENGTH]     = $request->length() + strlen($matches[0]);
        $request[Arg::MATCHED]    = $request->length() == strlen($request->path());
        $request[Arg::PARAMS]     = $this->params($route->map(), $matches, $route->defaults());

        return $request;
    }
}
