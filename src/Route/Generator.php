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
     * @param array|null $expressions
     */
    function __construct($class = null, array $expressions = null)
    {
        $class && $this->class = $class;
        $expressions && $this->expressions = $expressions + $this->expressions;
    }

    /**
     * @param array|\ArrayAccess $route
     * @return string
     */
    protected function createDefault($route = [])
    {
        return new $this->class($route);
    }

    /**
     * @param array|Route $route
     * @param bool $compile
     * @return Route
     */
    function __invoke($route, $compile = true)
    {
        return $this->build($route, $compile);
    }
}
