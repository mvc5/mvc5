<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Event\Event;
use Mvc5\Route\Route;
use Mvc5\Route\Request;

class Path
{
    /**
     * @param Request $request
     * @param Route $route
     * @return array
     */
    protected function defaults(Request $request, Route $route)
    {
        return ($request[Arg::PARAMS] ?: []) + $route->defaults();
    }

    /**
     * @param array $map
     * @param array $matches
     * @param array $params
     * @return array
     */
    protected function map(array $map, array $matches, array $params = [])
    {
        foreach($map as $name => $arg) {
            !empty($matches[$name]) && $params[$arg] = $matches[$name];
        }

        return $params;
    }

    /**
     * @param array $matches
     * @param array $params
     * @return array
     */
    protected function named(array $matches, array $params = [])
    {
        foreach($matches as $name => $value) {
            is_string($name) && $params[$name] = $value;
        }

        return $params;
    }

    /**
     * @param array $map
     * @param array $matches
     * @param array $params
     * @return array
     */
    protected function params(array $map, array $matches, array $params = [])
    {
        return $map ? $this->map($map, $matches, $params) : $this->named($matches, $params);
    }

    /**
     * @param Event $event
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Event $event, Request $request, Route $route)
    {
        if (!preg_match('(\G' . $route->regex() . ')', $request->path(), $matches, null, $request->length())) {
            return null;
        }

        $request[Arg::CONTROLLER] = $route->controller();
        $request[Arg::LENGTH]     = $request->length() + strlen($matches[0]);
        $request[Arg::MATCHED]    = $request->length() == strlen($request->path());
        $request[Arg::PARAMS]     = $this->params($route->map(), $matches, $this->defaults($request, $route));

        return $request->matched() || ($route->children() && $event->stop()) ? $request : null;
    }
}
