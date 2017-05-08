<?php
/**
 *
 */

namespace Mvc5\Service\Config;

trait Container
{
    /**
     * @var array|mixed
     */
    protected $config = [];

    /**
     * @var array|mixed
     */
    protected $container = [];

    /**
     * @var array|mixed
     */
    protected $services = [];

    /**
    * @return array|mixed
     */
    function config()
    {
        return $this->config;
    }

    /**
     * @param string $name
     * @return array|callable|null|object|string
     */
    protected function configured($name)
    {
        return $this->services[$name] ?? null;
    }

    /**
     * @return array|mixed
     */
    function container()
    {
        return $this->container;
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
        return $this->stored($name);
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
     * @param array|string $name
     * @return void
     */
    function remove($name)
    {
        foreach((array) $name as $key) {
            unset($this->container[$key]);
        }
    }

    /**
     *
     */
    function rewind()
    {
        is_array($this->container) ? reset($this->container) : $this->container->rewind();
    }

    /**
     * @return array|mixed
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
     * @param string $name
     * @return mixed
     */
    protected function stored($name)
    {
        return $this->container[$name] ?? null;
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
