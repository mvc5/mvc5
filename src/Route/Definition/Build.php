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
     * @param Route $route
     * @param bool $compile
     * @return array|Route
     */
    protected function definition(Route $route, $compile = true)
    {
        $route = $this->host($route, $route[Arg::HOST] ?? []);

        if (!isset($route[Arg::PATH])) {
            return isset($route[Arg::REGEX]) ? $route : Exception::invalidArgument('Route path not specified');
        }

        !isset($route[Arg::TOKENS]) && $route = $route->with(Arg::TOKENS, $this->tokens(
            $route[Arg::PATH], $route[Arg::CONSTRAINTS] ?? []
        ));

        $compile && !isset($route[Arg::REGEX]) &&
            $route = $route->with(Arg::REGEX, $this->regex($route[Arg::TOKENS]));

        return $route;
    }

    /**
     * @param Route $route
     * @param $host
     * @return array|mixed|\Mvc5\Config\Base
     */
    protected function host(Route $route, $host)
    {
        if (!$host || !is_array($host)) {
            return $route;
        }

        !isset($host[Arg::TOKENS]) &&
            $host[Arg::TOKENS] = $this->tokens($host[Arg::NAME], $host[Arg::CONSTRAINTS] ?? []);

        !isset($host[Arg::REGEX]) &&
            $host[Arg::REGEX] = $this->regex($host[Arg::TOKENS]);

        return $route->with(Arg::HOST, $host);
    }
}
