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
     * @param array $map
     * @param array $matches
     * @param array $matched
     * @return array
     */
    protected function map(array $map, array $matches, array $matched = [])
    {
        foreach($map as $name => $arg) {
            !empty($matches[$name]) && $matched[$arg] = $matches[$name];
        }

        return $matched;
    }

    /**
     * @param array $matches
     * @param array $matched
     * @return array
     */
    protected function named(array $matches, array $matched = [])
    {
        foreach($matches as $name => $value) {
            is_string($name) && $matched[$name] = $value;
        }

        return $matched;
    }

    /**
     * @param array $map
     * @param array $matches
     * @param array $defaults
     * @return array
     */
    protected function params(array $map, array $matches, array $defaults = [])
    {
        return ($map ? $this->map($map, $matches) : $this->named($matches)) + $defaults;
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
        $request[Arg::PARAMS]     = $this->params($route->map(), $matches, $route->defaults());

        return $request->matched() || ($route->children() && $event->stop()) ? $request : null;
    }
}
