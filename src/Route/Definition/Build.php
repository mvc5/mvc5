<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Arg;
use Mvc5\Exception;
use Mvc5\Route\Config;
use Mvc5\Route\Route;

use function is_array;

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
     * @throws \Throwable
     */
    protected function build($route, bool $compile = true) : Route
    {
        return $this->definition($this->create($route), $compile);
    }

    /**
     * @param array|Route $route
     * @return Route
     */
    protected function create($route) : Route
    {
        return $route instanceof Route ? $route :
            $this->createDefault($route, $route[Arg::CLASS_NAME] ?? Config::class);
    }

    /**
     * @param array|\ArrayAccess $route
     * @param string $class
     * @return Route
     */
    protected function createDefault($route = [], string $class = Config::class) : Route
    {
        return new $class($route);
    }

    /**
     * @param Route $route
     * @param bool $compile
     * @return Route
     * @throws \Throwable
     */
    protected function definition(Route $route, bool $compile = true) : Route
    {
        /** @var Route $route */
        $route = $this->host($route, $route[Arg::HOST]);

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
     * @param array|mixed $host
     * @return Route
     * @throws \Throwable
     */
    protected function host(Route $route, $host) : Route
    {
        if (!is_array($host)) {
            return $route;
        }

        $host[Arg::TOKENS] ??= $this->tokens($host[Arg::NAME], $host[Arg::CONSTRAINTS] ?? []);

        $host[Arg::REGEX] ??= $this->regex($host[Arg::TOKENS]);

        return $route->with(Arg::HOST, $host);
    }
}
