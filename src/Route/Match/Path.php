<?php
/**
 *
 */

namespace Mvc5\Route\Match;

use Mvc5\Arg;
use Mvc5\Route\Definition;
use Mvc5\Route\Route;

class Path
{
    /**
     * @param array $paramMap
     * @param string[] $matches
     * @return array
     */
    protected function params(array $paramMap, array $matches)
    {
        $matched = [];

        foreach($paramMap as $name => $param) {
            !empty($matches[$name]) && $matched[$param] = $matches[$name];
        }

        return $matched;
    }

    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    function __invoke(Route $route, Definition $definition)
    {
        if (!preg_match('(\G' . $definition->regex() . ')', $route->path(), $matches, null, $route->length())) {
            return null;
        }

        $route[Arg::CONTROLLER] = $definition->controller();
        $route[Arg::LENGTH]     = $route->length() + strlen($matches[0]);
        $route[Arg::MATCHED]    = $route->length() == strlen($route->path());
        $route[Arg::PARAMS]     = $this->params($definition->paramMap(), $matches) + $definition->defaults() + $route->params();

        return $route;
    }
}
