<?php
/**
 *
 */

namespace Mvc5\Resolver;

use RuntimeException;

trait Initializer
{
    /**
     * @var array
     */
    protected $pending = [];

    /**
     * @param array|callable|null|object|string $config
     * @param array $args
     * @param callable $callback
     * @return callable|null|object
     */
    protected abstract function create($config, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return callable|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @param null $config
     * @return null|object|callable
     */
    protected function initialize($name, $config = null)
    {
        return $this->initializing($name) ?:
            $this->initialized($name, $config ? $this->create($config) : $this->plugin($name));
    }

    /**
     * @param string $name
     * @param callable|null|object $service
     * @return callable|null|object
     */
    protected function initialized($name, $service = null)
    {
        $this->pending[$name] = false;

        null !== $service && $service && $this->set($name, $service);

        return $service;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function initializing($name)
    {
        if (!empty($this->pending[$name])) {
            throw new RuntimeException('Circular dependency: ' . $name);
        }

        $this->pending[$name] = true;

        return false;
    }

    /**
     * @param $config
     * @param array $args
     * @return array|callable|null|object|string
     */
    protected abstract function resolve($config, array $args = []);

    /**
     * @param string $name
     * @param mixed $service
     * @return void
     */
    protected abstract function set($name, $service);
}
