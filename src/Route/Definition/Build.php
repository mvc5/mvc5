<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use Mvc5\Exception;
use Mvc5\Route\Config;
use Mvc5\Route\Route;

trait Build
{
    /**
     *
     */
    use Regex;
    use Tokens;

    /**
     * @param array|Route $route
     * @param bool $compile
     * @return Route
     */
    protected function build($route, $compile = true)
    {
        return $this->definition($this->create($route), $compile);
    }

    /**
     * @param array|Route $route
     * @return Route
     */
    protected function create($route)
    {
        return $route instanceof Route ? $route : (
            isset($route[Arg::CLASS_NAME]) ? new $route[Arg::CLASS_NAME]($route) :
                $this->createDefault($route)
        );
    }

    /**
     * @param array|\ArrayAccess $route
     * @return Route
     */
    protected function createDefault($route = [])
    {
        return new Config($route);
    }

    /**
     * @param array|Route $route
     * @param bool $compile
     * @return array|Route
     */
    protected function definition($route, $compile = true)
    {
        if (!isset($route[Arg::PATH])) {
            return isset($route[Arg::REGEX]) ? $route : Exception::invalidArgument('Route path not specified');
        }

        !isset($route[Arg::TOKENS]) && $route = $route->with(Arg::TOKENS, $this->tokens(
            $route[Arg::PATH], isset($route[Arg::CONSTRAINTS]) ? $route[Arg::CONSTRAINTS] : []
        ));

        $compile && !isset($route[Arg::REGEX]) &&
            $route = $route->with(Arg::REGEX, $this->regex($route[Arg::TOKENS]));

        return $route;
    }
}
