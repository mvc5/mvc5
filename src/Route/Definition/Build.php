<?php
/**
 *
 */

namespace Mvc5\Route\Definition;

use Mvc5\Exception;
use Mvc5\Route\Config;
use Mvc5\Route\Route;

use function is_array;

use const Mvc5\{ CLASS_NAME, CONSTRAINTS, HOST, NAME, PATH, REGEX, TOKENS };

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
            $this->createDefault($route, $route[CLASS_NAME] ?? Config::class);
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
        $route = $this->host($route, $route[HOST]);

        if (!isset($route[PATH])) {
            return isset($route[REGEX]) ? $route : Exception::invalidArgument('Route path not specified');
        }

        !isset($route[TOKENS]) && $route = $route->with(TOKENS, $this->tokens(
            $route[PATH], $route[CONSTRAINTS] ?? []
        ));

        $compile && !isset($route[REGEX]) &&
            $route = $route->with(REGEX, $this->regex($route[TOKENS]));

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

        $host[TOKENS] ??= $this->tokens($host[NAME], $host[CONSTRAINTS] ?? []);

        $host[REGEX] ??= $this->regex($host[TOKENS]);

        return $route->with(HOST, $host);
    }
}
