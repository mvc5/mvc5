<?php
/**
 *
 */

namespace Mvc5\Service\Container;

use Mvc5\Config\ArrayAccess;
use Mvc5\Config\Configuration;

trait Container
{
    /**
     *
     */
    use ArrayAccess;

    /**
     * @var array|Configuration|null
     */
    protected $config;

    /**
     * @var array|ArrayAccess
     */
    protected $container = [];

    /**
     * @var array|ArrayAccess
     */
    protected $services = [];

    /**
     * @return array|Configuration
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * @param array|Configuration $config
     */
    public function configuration($config)
    {
        $this->config = $config;
    }

    /**
     * @param string $name
     * @param mixed $config
     * @return void
     */
    public function configure($name, $config)
    {
        $this->services[$name] = $config;
    }

    /**
     * @param string $name
     * @return array|callable|null|object|string
     */
    public function configured($name)
    {
        return isset($this->services[$name]) ? $this->services[$name] : null;
    }

    /**
     * @param array|ArrayAccess $container
     */
    public function container($container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @return object|null
     */
    public function get($name)
    {
        return $this->service($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->container[$name]);
    }

    /**
     * @param string $name
     * @return void
     */
    public function remove($name)
    {
        unset($this->container[$name]);
    }

    /**
     * @param string $name
     * @return object|null
     */
    public function service($name)
    {
        return isset($this->container[$name]) ? $this->container[$name] : null;
    }

    /**
     * @param array|\ArrayAccess $services
     */
    public function services($services)
    {
        $this->services = $services;
    }

    /**
     * @param string $name
     * @param mixed $service
     * @return mixed
     */
    public function set($name, $service)
    {
        return $this->container[$name] = $service;
    }
}
