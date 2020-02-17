<?php
/**
 *
 */

namespace Mvc5\Route;

class Generator
{
    /**
     *
     */
    use Definition\Build;

    /**
     * @var string
     */
    protected string $class = Config::class;

    /**
     * @param string|null $class
     * @param array|null $expressions
     */
    function __construct(string $class = null, array $expressions = null)
    {
        $class && $this->class = $class;
        $expressions && $this->expressions = $expressions + $this->expressions;
    }

    /**
     * @param array|\ArrayAccess $route
     * @return Route
     */
    protected function createDefault($route = []) : Route
    {
        return new $this->class($route);
    }

    /**
     * @param array|\ArrayAccess|Route $route
     * @param bool $compile
     * @return Route
     * @throws \Throwable
     */
    function __invoke($route, bool $compile = true) : Route
    {
        return $this->build($route, $compile);
    }
}
