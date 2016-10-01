<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Route\Request;

class Controller
{
    /**
     * @param $action
     * @param $controller
     * @param array $options
     * @return string
     */
    protected function name($action, $controller, array $options = [])
    {
        return $options[Arg::PREFIX] . $controller
            . ($action ? $options[Arg::SPLIT] . $action : '') . $options[Arg::SUFFIX];
    }

    /**
     * @param $name
     * @param array $options
     * @return string
     */
    protected function format($name, array $options = [])
    {
        foreach($options[Arg::SEPARATORS] as $separator => $replacement) {
            $name = str_replace(' ', $replacement, ucwords(str_replace($separator, ' ', $name)));
        }

        return $name;
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Request
     */
    function __invoke(Request $request, Route $route)
    {
        if ($request->controller()) {
            return $request;
        }

        $action     = $request->param(Arg::ACTION);
        $controller = $request->param(Arg::CONTROLLER);
        $options    = $route->options();

        $name = $this->name($this->format($action, $options), $this->format($controller, $options), $options);

        if (!class_exists($name)) {
            return null;
        }

        $request[Arg::CONTROLLER] = $name;

        return $request;
    }
}
