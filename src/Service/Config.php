<?php
/**
 *
 */

namespace Mvc5\Service;

use Mvc5\Config\Config as Base;

trait Config
{
    /**
     *
     */
    use Base;

    /**
     * @var array|\ArrayAccess
     */
    protected $container = [];

    /**
     * @var array|\ArrayAccess
     */
    protected $services = [];

    /**
     * @param array|\ArrayAccess|null $config
     * @return array|\ArrayAccess|null
     */
    public function config($config = null)
    {
        return null !== $config ? $this->config = $config : $this->config;
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
        return $this->services[$name] ?? null;
    }

    /**
     * @param array|\ArrayAccess $config
     * @return array|\ArrayAccess
     */
    public function container($config = null)
    {
        return null !== $config ? $this->container = $config : $this->container;
    }

    /**
     * @param string $name
     * @return object|null
     */
    public function offsetGet($name)
    {
        return $this->shared($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function offsetExists($name)
    {
        return isset($this->container[$name]);
    }

    /**
     * @param string $name
     * @return void
     */
    public function offsetUnset($name)
    {
        unset($this->container[$name]);
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
    public function services($config = null)
    {
        return null !== $config ? $this->services = $config : $this->services;
    }

    /**
     * @param string $name
     * @param mixed $config
     * @return mixed
     */
    public function offsetSet($name, $config)
    {
        return $this->container[$name] = $config;
    }
}
