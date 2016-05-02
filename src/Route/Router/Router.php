<?php
/**
 *
 */

namespace Mvc5\Route\Router;

use Mvc5\Arg;
use Mvc5\Route\Definition;
use Mvc5\Route\Route;

trait Router
{
    /**
     * @var array|Definition
     */
    protected $definition;

    /**
     * @param array|Definition $definition
     */
    function __construct($definition)
    {
        $this->definition = $definition;
    }

    /**
     * @param array|Definition $definition
     * @return Definition
     */
    protected abstract function definition($definition);

    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    protected function dispatch(Route $route, Definition $definition)
    {
        $route = $this->match($definition, $route);

        if (!$route instanceof Route) {
            return $route;
        }

        !$route->name() && $route[Arg::NAME] = $definition->name();

        if ($route->matched()) {
            return $route;
        }

        $parent = $route->name();

        foreach($definition->children() as $name => $definition) {
            $route[Arg::NAME] = $this->name() === $parent ? $name : $parent . Arg::SEPARATOR . $name;

            if ($match = $this->dispatch(clone $route, $this->routeDefinition($definition))) {
                return $match;
            }
        }

        return null;
    }

    /**
     * @param Definition $definition
     * @param Route $route
     * @return Route
     */
    protected abstract function match($definition, $route);

    /**
     * @return string
     */
    protected function name()
    {
        return $this->definition[Arg::NAME];
    }

    /**
     * @param array|Definition $definition
     * @return Definition
     */
    protected function routeDefinition($definition)
    {
        return $definition instanceof Definition && isset($definition[Arg::REGEX])
            ? $definition : $this->definition($definition);
    }

    /**
     * @param Route $route
     * @return Route
     */
    function __invoke(Route $route)
    {
        return $this->dispatch(clone $route, $this->routeDefinition($this->definition));
    }
}
