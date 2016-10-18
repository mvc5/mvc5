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
     * @param array $matches
     * @param array $params
     * @return array
     */
    protected function params(array $matches, array $params = [])
    {
        foreach($matches as $name => $value) {
            is_string($name) && $params[$name] = $value;
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
        $request[Arg::PARAMS]     = $this->params($matches, $route->defaults() + $request->params());

        return $request->matched() || ($route->children() && $event->stop()) ? $request : null;
    }
}
