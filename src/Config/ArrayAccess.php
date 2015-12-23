<?php
/**
 *
 */

namespace Mvc5\Config;

trait ArrayAccess
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->config);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->config);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->config);
    }

    /**
     *
     */
    public function next()
    {
        next($this->config);
    }

    /**
     *
     */
    public function rewind()
    {
        reset($this->config);
    }

    /**
     * @param mixed $name
     * @return bool
     */
    public function offsetExists($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * @param mixed $name
     * @return mixed
     */
    public function offsetGet($name)
    {
        return $this->config[$name] ?? null;
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return mixed $value
     */
    public function offsetSet($name, $value)
    {
        return $this->config[$name] = $value;
    }

    /**
     * @param mixed $name
     */
    public function offsetUnset($name)
    {
        unset($this->config[$name]);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return null !== $this->key();
    }
}
