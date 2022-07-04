<?php
/**
 *
 */

namespace Mvc5\Resolver;

use Mvc5\Config\Model;
use Mvc5\Config\Configuration;

use function is_string;

trait Base
{
    /**
     * @var Model
     */
    protected Model $config;

    /**
     * @var Configuration
     */
    protected Configuration $container;

    /**
     * @var Model
     */
    protected Model $services;

    /**
     * @param string $name
     * @return mixed
     */
    protected function configured(string $name)
    {
        return $this->services[$name] ?? null;
    }

    /**
     * @return int
     */
    function count() : int
    {
        return $this->container->count();
    }

    /**
     * @return mixed
     */
    function current() : mixed
    {
        return $this->container->current();
    }

    /**
     * @param array|string $name
     * @return mixed
     */
    function get($name)
    {
        if (is_string($name)) {
            return $this->stored($name) ?? $this($name);
        }

        $matched = [];

        foreach($name as $key) {
            $matched[$key] = $this->stored($key) ?? $this($key);
        }

        return $matched;
    }

    /**
     * @param array|string $name
     * @return bool
     */
    function has($name) : bool
    {
        if (is_string($name)) {
            return isset($this->container[$name]) || isset($this->services[$name]);
        }

        foreach($name as $key) {
            if (!isset($this->container[$key]) && !isset($this->services[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return mixed
     */
    function key() : mixed
    {
        return $this->container->key();
    }

    /**
     *
     */
    function next() : void
    {
        $this->container->next();
    }

    /**
     * @param array|string $name
     */
    function remove($name) : void
    {
        $this->container->remove($name);
    }

    /**
     *
     */
    function rewind() : void
    {
        $this->container->rewind();
    }

    /**
     * @param array|string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value = null) : mixed
    {
        return $this->container->set($name, $value);
    }

    /**
     * @param array|string $name
     * @param mixed $plugin
     * @param array $args
     * @return mixed
     * @throws \Throwable
     */
    function shared($name, $plugin = null, array $args = [])
    {
        if (is_string($name)) {
            return $this->stored($name) ?? $this->set($name, $this->plugin($plugin ?? $name, $args));
        }

        $matched = [];

        foreach($name as $key) {
            $matched[$key] = $this->stored($key) ?? $this->set($key, $this->plugin($key, $args));
        }

        return $matched;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function stored(string $name)
    {
        return $this->container[$name] ?? null;
    }

    /**
     * @return bool
     */
    function valid() : bool
    {
        return $this->container->valid();
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @return mixed
     */
    abstract function __invoke($plugin, array $args = []);
}
