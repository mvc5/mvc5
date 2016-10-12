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
        return $route->defaults() + ($request[Arg::PARAMS] ?: []);
    }

    /**
     * @param $name
     * @param array $map
     * @return string
     */
    protected function map($name, array $map = [])
    {
        return isset($map[$name]) ? $map[$name] : $name;
    }

    /**
     * @param array $matches
     * @param array $map
     * @param array $params
     * @return array
     */
    protected function params(array $matches, array $map = [], array $params = [])
    {
        foreach($matches as $name => $value) {
            is_string($name) && $params[$this->map($name, $map)] = $value;
        }

        return $params;
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
        $request[Arg::PARAMS]     = $this->params($matches + $this->defaults($request, $route), $route->map());

        return $request->matched() || ($route->children() && $event->stop()) ? $request : null;
    }
}
