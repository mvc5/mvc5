<?php
/**
 *
 */

namespace Mvc5\Config;

trait Config
{
    /**
     *
     */
    use ArrayAccess;

    /**
     * @var array|Configuration
     */
    protected $config = [];

    /**
     * @param array $config
     */
    function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * @return int
     */
    function count()
    {
        return count($this->config);
    }

    /**
     * @return mixed
     */
    function current()
    {
        return is_array($this->config) ? current($this->config) : $this->config->current();
    }

    /**
     * @param string $name
     * @return mixed
     */
    function get($name)
    {
        return $this->config[$name] ?? null;
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * @return mixed
     */
    function key()
    {
        return is_array($this->config) ? key($this->config) : $this->config->key();
    }

    /**
     *
     */
    function next()
    {
        is_array($this->config) ? next($this->config) : $this->config->next();
    }

    /**
     * @param string $name
     * @return void
     */
    function remove($name)
    {
        unset($this->config[$name]);
    }

    /**
     *
     */
    function rewind()
    {
        is_array($this->config) ? reset($this->config) : $this->config->rewind();
    }

    /**
     * @param string $name
     * @param mixed $config
     * @return mixed $config
     */
    function set($name, $config)
    {
        return $this->config[$name] = $config;
    }

    /**
     * @return bool
     */
    function valid()
    {
        return is_array($this->config) ? null !== $this->key() : $this->config->valid();
    }

    /**
     *
     */
    function __clone()
    {
        is_object($this->config) &&
            $this->config = clone $this->config;
    }
}
