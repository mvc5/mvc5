<?php
/**
 *
 */

namespace Mvc5\Service\Config;

use Mvc5\Config\Config;
use Mvc5\Config\Configuration;

trait Container
{
    /**
     *
     */
    use Config;

    /**
     * @var array|Configuration
     */
    protected $container = [];

    /**
     * @var array|Configuration
     */
    protected $services = [];

    /**
     * @param array|Configuration|null $config
     * @return array|Configuration|null
     */
    function config($config = null)
    {
        return null !== $config ? $this->config = $config : $this->config;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function configure($name, $value)
    {
        return $this->services[$name] = $value;
    }

    /**
     * @param string $name
     * @return array|callable|null|object|string
     */
    function configured($name)
    {
        return $this->services[$name] ?? null;
    }

    /**
     * @param array|Configuration $config
     * @return array|Configuration
     */
    function container($config = null)
    {
        return null !== $config ? $this->container = $config : $this->container;
    }

    /**
     * @return int
     */
    function count()
    {
        return count($this->container);
    }

    /**
     * @return mixed
     */
    function current()
    {
        return is_array($this->container) ? current($this->container) : $this->container->current();
    }

    /**
     * @param string $name
     * @return object|null
     */
    function get($name)
    {
        return $this->shared($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name)
    {
        return isset($this->container[$name]);
    }

    /**
     * @return mixed
     */
    function key()
    {
        return is_array($this->container) ? key($this->container) : $this->container->key();
    }

    /**
     *
     */
    function next()
    {
        is_array($this->container) ? next($this->container) : $this->container->next();
    }

    /**
     * @param string $name
     * @return void
     */
    function remove($name)
    {
        unset($this->container[$name]);
    }

    /**
     *
     */
    function rewind()
    {
        is_array($this->container) ? reset($this->container) : $this->container->rewind();
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function shared($name)
    {
        return $this->container[$name] ?? null;
    }

    /**
     * @param array|\ArrayAccess $config
     * @return array|\ArrayAccess
     */
    function services($config = null)
    {
        return null !== $config ? $this->services = $config : $this->services;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value)
    {
        return $this->container[$name] = $value;
    }

    /**
     * @return bool
     */
    function valid()
    {
        return is_array($this->container) ? null !== $this->key() : $this->container->valid();
    }

    /**
     *
     */
    function __clone()
    {
        is_object($this->config) &&
            $this->config = clone $this->config;

        is_object($this->container) &&
            $this->container = clone $this->container;

        is_object($this->services) &&
            $this->services = clone $this->services;
    }
}
