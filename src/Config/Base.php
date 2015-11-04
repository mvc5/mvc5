<?php
/**
 *
 */

namespace Mvc5\Config;

trait Base
{
    /**
     *
     */
    use ArrayAccess;

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
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->config[$name]);
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
     * @param string $name
     * @return void
     */
    public function remove($name)
    {
        unset($this->config[$name]);
    }

    /**
     *
     */
    public function rewind()
    {
        reset($this->config);
    }

    /**
     * @param string $name
     * @param mixed $config
     * @return mixed $config
     */
    public function set($name, $config)
    {
        return $this->config[$name] = $config;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return null !== $this->key();
    }
}
