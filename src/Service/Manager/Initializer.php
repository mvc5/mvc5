<?php
/**
 *
 */

namespace Mvc5\Service\Manager;

use RuntimeException;

trait Initializer
{
    /**
     * @var array
     */
    protected $pending = [];

    /**
     * @param string $name
     * @param callable $callback
     * @param array $args
     * @return callable|null|object
     */
    protected abstract function plugin($name, array $args = [], callable $callback = null);

    /**
     * @param string $name
     * @param array $args
     * @param callable $callback
     * @return null|object|callable
     */
    protected function initialize($name, array $args = [], callable $callback = null)
    {
        return $this->initializing($name) ?: $this->initialized($name, $this->plugin($name, $args, $callback));
    }

    /**
     * @param string $name
     * @param callable|null|object $service
     * @return callable|null|object
     */
    protected function initialized($name, $service = null)
    {
        $this->pending[$name] = false;

        $service && $this->set($name, $service);

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
     * @param string $name
     * @param mixed $service
     * @return void
     */
    public abstract function set($name, $service);
}
