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
        return $this->initializing($name) ?? $this->initialized($name, $this->plugin($config ?? $name));
    }

    /**
     * @param string $name
     * @param callable|null|object $service
     * @return callable|null|object
     */
    protected function initialized($name, $service = null)
    {
        $this->pending[$name] = false;

        null !== $service && $this->set($name, $service);

        return $service;
    }

    /**
     * @param string $name
     * @return null
     */
    protected function initializing($name)
    {
        if (!empty($this->pending[$name])) {
            throw new RuntimeException('Circular dependency: ' . $name);
        }

        $this->pending[$name] = true;

        return null;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    protected abstract function set($name, $value);
}
