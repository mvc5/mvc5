<?php
/**
 *
 */

namespace Mvc5\Resolver;

use function count;
use function current;
use function is_string;
use function key;
use function next;
use function reset;

trait Container
{
    /**
     * @var array|\ArrayAccess
     */
    protected $config = [];

    /**
     * @var array|\ArrayAccess|\Iterator
     */
    protected $container = [];

    /**
     * @var array|\ArrayAccess
     */
    protected $services = [];

    /**
    * @return array|\ArrayAccess
     */
    function config()
    {
        return $this->config;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function configured(string $name)
    {
        return $this->services[$name] ?? null;
    }

    /**
     * @return array|\ArrayAccess|\Iterator
     */
    function container()
    {
        return $this->container;
    }

    /**
     * @return int
     */
    function count() : int
    {
        return count($this->container);
    }

    /**
     * @return mixed
     */
    function current()
    {
        return $this->container instanceof \Iterator ? $this->container->current() : current($this->container);
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
     * @return int|string|null
     */
    function key()
    {
        return $this->container instanceof \Iterator ? $this->container->key() : key($this->container);
    }

    /**
     *
     */
    function next() : void
    {
        $this->container instanceof \Iterator ? $this->container->next() : next($this->container);
    }

    /**
     * @param array|string $name
     */
    function remove($name) : void
    {
        foreach((array) $name as $key) {
            unset($this->container[$key]);
        }
    }

    /**
     *
     */
    function rewind() : void
    {
        $this->container instanceof \Iterator ? $this->container->rewind() : reset($this->container);
    }

    /**
     * @return array|\ArrayAccess|\Iterator
     */
    function services()
    {
        return $this->services;
    }

    /**
     * @param array|string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value = null)
    {
        if (is_string($name)) {
            return $this->container[$name] = $value;
        }

        foreach($name as $key => $value) {
            $this->container[$key] = $value;
        }

        return $name;
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
        return $this->container instanceof \Iterator ? $this->container->valid() : null !== key($this->container);
    }

    /**
     * @param string|mixed $plugin
     * @param array $args
     * @return mixed
     */
    abstract function __invoke($plugin, array $args = []);
}
