<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Service\Builder;
use Mvc5\Service\Container;
use Mvc5\Service\Manager;

trait Build
{
    /**
     * @var bool
     */
    protected $strict = false;

    /**
     * @param array $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function build(array $name, array $args = [], callable $callback = null)
    {
        return $this->compose($this->create(array_shift($name), $args, $callback), $name, $args, $callback);
    }

    /**
     * @param $name
     * @param $config
     * @param array $args
     * @param callable|null $callback
     * @return callable|object
     */
    protected function callback(string $name, $config = null, array $args = [], callable $callback = null)
    {
        return $callback && !class_exists($name) ? $callback($name) : (
            $config || !$this->strict || $this->configured($name) ? $this->make($name, $args) : null
        );
    }

    /**
     * @param array $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function combine(array $name, array $args = [], callable $callback = null)
    {
        return $this->compose($this->first(array_shift($name), $name, $args, $callback), $name, $args, $callback);
    }

    /**
     * @param $plugin
     * @param array $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function compose($plugin, array $name = [], array $args = [], callable $callback = null)
    {
        return !$name ? $plugin : $this->compose(
            $this->composite($plugin, array_shift($name), $args, $callback), $name, $args, $callback
        );
    }

    /**
     * @param $plugin
     * @param string $name
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|null|object|string
     */
    protected function composite($plugin, string $name, array $args = [], callable $callback = null)
    {
        return $plugin instanceof Manager ? $plugin->plugin($name, $args, $callback) : (
            $plugin instanceof Container ? $this->plugin($plugin[$name], $args, $callback) :
                $this->resolve($plugin[$name], $args)
        );
    }

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function create(string $name, array $args = [], callable $callback = null)
    {
        return $this->unique($name, $this->configured($name), $args, $callback);
    }

    /**
     * @param string $plugin
     * @param array $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function first(string $plugin, array $name, array $args = [], callable $callback = null)
    {
        return !$name ? $this->callback($plugin, null, $args, $callback) : $this->create($plugin, $args, $callback);
    }

    /**
     * @param string $name
     * @param array $args
     * @return callable|object
     */
    protected function make(string $name, array $args = [])
    {
        return Builder::create($name, $args, $this);
    }

    /**
     * @param $name
     * @param $plugin
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function unique(string $name, $plugin, array $args = [], callable $callback = null)
    {
        return $plugin && $name !== $plugin ?
            $this->plugin($plugin, $args, $callback, $name) : $this->callback($name, $plugin, $args, $callback);
    }

    /**
     * @param $plugin
     * @param array $args
     * @return array|callable|null|object|string
     */
    abstract function __invoke($plugin, array $args = []);
}
