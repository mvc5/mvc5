<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use Mvc5\Route\Config;
use Mvc5\Route\Route;
use RuntimeException;

trait Build
{
    /**
     *
     */
    use Params;
    use Regex;
    use Tokens;

    /**
     * @param array|Route $route
     * @param bool $compile
     * @param bool $recursive
     * @return array|Route
     */
    protected function definition($route, $compile = true, $recursive = false)
    {
        if (!isset($route[Arg::ROUTE])) {
            throw new RuntimeException('Route not specified');
        }

        !isset($route[Arg::CONSTRAINTS]) && $route[Arg::CONSTRAINTS] = [];

        !isset($route[Arg::TOKENS]) && $route[Arg::TOKENS]
            = $this->tokens($route[Arg::ROUTE]);

        $compile && !isset($route[Arg::REGEX]) && $route[Arg::REGEX]
            = $this->regex($route[Arg::TOKENS], $route[Arg::CONSTRAINTS]);

        !isset($route[Arg::MAP]) && $route[Arg::MAP]
            = $this->params($route[Arg::TOKENS]);

        $recursive && isset($route[Arg::CHILDREN]) && $route[Arg::CHILDREN]
            = $this->children($route[Arg::CHILDREN], $compile, $recursive);

        return $route;
    }

    /**
     * @param array $routes
     * @param bool $compile
     * @param bool $recursive
     * @return array
     */
    protected function children(array $routes, $compile = true, $recursive = true)
    {
        foreach($routes as $name => $route) {
            $routes[$name] = $this->build($route, $compile, $recursive);
        }

        return $routes;
    }

    /**
     * @param array|Route $route
     * @return Route
     */
    protected function create($route)
    {
        if ($route instanceof Route) {
            return $route;
        }

        if (isset($route[Arg::CLASS_NAME])) {
            return new $route[Arg::CLASS_NAME]($route);
        }

        return $this->createDefault($route);
    }

    /**
     * @param array $route
     * @return string
     */
    protected function createDefault(array $route = [])
    {
        return new Config($route);
    }

    /**
     * @param array|Route $route
     * @param bool $compile
     * @param bool $recursive
     * @return Route
     */
    protected function build($route, $compile = true, $recursive = false)
    {
        return $this->create($this->definition($route, $compile, $recursive));
    }
}
