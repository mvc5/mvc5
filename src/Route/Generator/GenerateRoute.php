<?php
/**
 *
 */

namespace Mvc5\Route\Generator;

trait GenerateRoute
{
    /**
     * @var RouteGenerator
     */
    protected $generator;

    /**
     * @param string $name
     * @param array $args
     * @return string
     */
    public function generate($name, array $args = [])
    {
        return $this->generator->url($name, $args);
    }

    /**
     * @param RouteGenerator $generator
     */
    public function setRouteGenerator(RouteGenerator $generator)
    {
        $this->generator = $generator;
    }
}
