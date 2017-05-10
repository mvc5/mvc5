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
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function build(array $config, array $args = [], callable $callback = null)
    {
        return $this->compose($this->create(array_shift($config), $args, $callback), $config, $args, $callback);
    }

    /**
     * @param $name
     * @param $config
     * @param array $args
     * @param callable|null $callback
     * @return callable|object
     */
    protected function callback($name, $config = null, array $args = [], callable $callback = null)
    {
        return $callback && !class_exists($name) ? $callback($name) : (
            $config || !$this->strict() || $this->configured($name) ? $this->make($name, $args) : null
        );
    }

    /**
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function combine(array $config, array $args = [], callable $callback = null)
    {
        return $this->compose($this->first(array_shift($config), $config, $args, $callback), $config, $args, $callback);
    }

    /**
     * @param $plugin
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function compose($plugin, array $config = [], array $args = [], callable $callback = null)
    {
        return !$config ? $plugin : $this->compose(
            $this->composite($plugin, array_shift($config), $args, $callback), $config, $args, $callback
        );
    }

    /**
     * @param $plugin
     * @param $name
     * @param array $args
     * @param callable|null $callback
     * @return array|callable|null|object|string
     */
    protected function composite($plugin, $name, array $args = [], callable $callback = null)
    {
        return $plugin instanceof Manager ? $plugin->plugin($name, $args, $callback) : (
            $plugin instanceof Container ? $this->plugin($plugin[$name], $args, $callback) :
                $this->resolve($plugin[$name], $args)
        );
    }

    /**
     * @param $name
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function create($name, array $args = [], callable $callback = null)
    {
        return $this->unique($name, $this->configured($name), $args, $callback);
    }

    /**
     * @param $name
     * @param array $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function first($name, array $config, array $args = [], callable $callback = null)
    {
        return !$config ? $this->callback($name, null, $args, $callback) : $this->create($name, $args, $callback);
    }

    /**
     * @param string $name
     * @param array $args
     * @return callable|object
     */
    protected function make($name, array $args = [])
    {
        return Builder::create($name, $args, $this);
    }

    /**
     * @param $name
     * @param $config
     * @param array $args
     * @param callable $callback
     * @return callable|object
     */
    protected function unique($name, $config, array $args = [], callable $callback = null)
    {
        return $config && $name !== $config ?
            $this->plugin($config, $args, $callback, $name) : $this->callback($name, $config, $args, $callback);
    }

    /**
     * @param string $name
     * @param array $args
     * @return array|callable|null|object|string
     */
    abstract function __invoke($name, array $args = []);
}
