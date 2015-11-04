<?php
/**
 *
 */

namespace Mvc5\Route\Router;

use Mvc5\Route\Definition\Definition;
use Mvc5\Route\Manager\ManageRoute;
use Mvc5\Route\Route;

class Router
    implements MatchRoute
{
    /**
     *
     */
    use ManageRoute;

    /**
     * @var array|Definition
     */
    protected $definition;

    /**
     * @param array|Definition $definition
     */
    public function __construct($definition)
    {
        $this->definition = $definition;
    }

    /**
     * @param array|Definition $definition
     * @return Definition
     */
    protected function create($definition)
    {
        return $definition instanceof Definition && !empty($definition[Definition::REGEX])
            ? $definition : $this->definition($definition);
    }

    /**
     * @param Route $route
     * @param Definition $definition
     * @return Route
     */
    protected function dispatch(Route $route, Definition $definition)
    {
        $route = $this->match($definition, $route);

        $route && !$route->name() && $route->set(Route::NAME, $definition->name());

        if (!$route || $route->matched()) {
            return $route;
        }

        $parent = $route->name();

        foreach($definition->children() as $name => $definition) {
            $route->set(Route::NAME, $this->name() === $parent ? $name : $parent . '/' . $name);

            if ($match = $this->dispatch(clone $route, $this->create($definition))) {
                return $match;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    protected function name()
    {
        return $this->definition[Definition::NAME];
    }

    /**
     * @param Route $route
     * @return Route
     */
    public function __invoke(Route $route)
    {
        return $this->dispatch(clone $route, $this->create($this->definition));
    }
}
