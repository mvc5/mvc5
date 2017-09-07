<?php
/**
 *
 */

namespace Mvc5\Resolver;

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
     * @param string $name
     * @return mixed
     */
    function get($name)
    {
        return $this->stored($name) ?? $this($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name) : bool
    {
        return isset($this->container[$name]) || isset($this->services[$name]);
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
    function next()
    {
        $this->container instanceof \Iterator ? $this->container->next() : next($this->container);
    }

    /**
     * @param array|string $name
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
     * @param string $name
     * @param mixed $service
     * @return mixed
     */
    protected function share(string $name, $service = null)
    {
        null !== $service
            && $this->set($name, $service);

        return $service;
    }

    /**
     * @param string $name
     * @param mixed $plugin
     * @return mixed
     */
    function shared(string $name, $plugin = null)
    {
        return $this->stored($name) ?? $this->share($name, $this->plugin($plugin ?? $name));
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
