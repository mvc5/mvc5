<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Arg;
use Mvc5\Route\Route;
use Mvc5\Signal;

class Plugin
{
    /**
     *
     */
    use Signal;

    /**
     * @var callable
     */
    protected $generator;

    /**
     * @var Route
     */
    protected $route;

    /**
     * @param Route $route
     * @param callable $generator
     */
    public function __construct(Route $route, callable $generator)
    {
        $this->generator = $generator;
        $this->route     = $route;
    }

    /**
     * @return callable
     */
    protected function generator()
    {
        return $this->generator;
    }

    /**
     * @param string $name
     * @param array $args
     * @return string
     */
    protected function url($name, array $args = [])
    {
        return $this->signal($this->generator(), [Arg::NAME => $name] + $args);
    }

    /**
     * @param null|string $name
     * @param array $args
     * @return string
     */
    public function __invoke($name = null, array $args = [])
    {
        return $this->url($name ?? $this->route->name(), $name ? $args : $args + $this->route->params());
    }
}
