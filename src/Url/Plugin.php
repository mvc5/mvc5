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
     * @param null|string $name
     * @return string
     */
    protected function name($name = null)
    {
        return $name ?? $this->route->name();
    }

    /**
     * @param array $options
     * @return array
     */
    protected function options(array $options = [])
    {
        return $options + [
            Arg::HOSTNAME => $this->route->hostname(),
            Arg::PORT     => $this->route->port(),
            Arg::SCHEME   => $this->route->scheme()
        ];
    }

    /**
     * @param null|string $name
     * @param array $args
     * @return array
     */
    protected function params($name = null, array $args = [])
    {
        return $name ? $args : $args + $this->route->params();
    }

    /**
     * @param string $name
     * @param array $args
     * @param array $options
     * @return string
     */
    protected function url($name, array $args = [], array $options = [])
    {
        return $this->signal($this->generator(), [$name, $args, $options]);
    }

    /**
     * @param null $name
     * @param array $args
     * @param array $options
     * @return string
     */
    public function __invoke($name = null, array $args = [], array $options = [])
    {
        return $this->url($this->name($name), $this->params($name, $args), $this->options($options));
    }
}
