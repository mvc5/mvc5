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
     * @param array $match
     * @param array $params
     * @return array
     */
    protected function params(array $match, array $params = [])
    {
        foreach($match as $name => $value) {
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
        if (!preg_match('(\G' . $route->regex() . ')', $request->path(), $match, null, $request->length())) {
            return null;
        }

        $request[Arg::CONTROLLER] = $route->controller();
        $request[Arg::LENGTH]     = $request->length() + strlen($match[0]);
        $request[Arg::MATCHED]    = $request->length() == strlen($request->path());
        $request[Arg::PARAMS]     = $this->params($match, $route->defaults() + $request->params());

        return $request->matched() || ($route->children() && $event->stop()) ? $request : null;
    }
}
