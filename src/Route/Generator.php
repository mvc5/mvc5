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
    protected $class = Config::class;

    /**
     * @param null|string $class
     */
    function __construct($class = null)
    {
        $class && $this->class = $class;
    }

    /**
     * @param array $route
     * @return string
     */
    protected function createDefault(array $route = [])
    {
        return new $this->class($route);
    }

    /**
     * @param array|Route $route
     * @param bool $compile
     * @param bool $recursive
     * @return Route
     */
    function __invoke($route, $compile = true, $recursive = false)
    {
        return $this->build($route, $compile, $recursive);
    }
}
