<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use Mvc5\Exception;
use Mvc5\Route\Config;
use Mvc5\Route\Route;
use Mvc5\Signal;

trait Build
{
    /**
     *
     */
    use Constraint;
    use Regex;
    use Signal;
    use Tokens;

    /**
     * @param array|Route $route
     * @param bool $compile
     * @param bool $recursive
     * @return array|Route
     */
    protected function definition($route, $compile = true, $recursive = false)
    {
        $recursive && isset($route[Arg::CHILDREN]) && $route[Arg::CHILDREN] =
            $this->children($route[Arg::CHILDREN], $compile, $recursive);

        if (!isset($route[Arg::ROUTE])) {
            return isset($route[Arg::REGEX]) ? $route : $this->signal(new Exception('Route path not specified'));
        }

        !isset($route[Arg::TOKENS]) && $route[Arg::TOKENS] =
            $this->tokens($route[Arg::ROUTE], isset($route[Arg::CONSTRAINTS]) ? $route[Arg::CONSTRAINTS] : []);

        $compile && !isset($route[Arg::REGEX]) && $route[Arg::REGEX] =
            $this->regex($route[Arg::TOKENS]);

        $route[Arg::CONSTRAINTS] = $this->constraint($route[Arg::TOKENS]);

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
     * @param array|\ArrayAccess $route
     * @return string
     */
    protected function createDefault($route = [])
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
