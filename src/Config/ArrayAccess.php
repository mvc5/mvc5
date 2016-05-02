<?php
/**
 *
 */

namespace Mvc5\Config;

trait ArrayAccess
{
    /**
     * @param string $name
     * @return mixed
     */
    abstract function get($name);

    /**
     * @param string $name
     * @return bool
     */
    abstract function has($name);

    /**
     * @param mixed $config
     * @return bool
     */
    function offsetExists($config)
    {
        return $this->has($config);
    }

    /**
     * @param mixed $config
     * @return mixed
     */
    function offsetGet($config)
    {
        return $this->get($config);
    }

    /**
     * @param mixed $config
     * @param mixed $value
     * @return mixed $value
     */
    function offsetSet($config, $value)
    {
        return $this->set($config, $value);
    }

    /**
     * @param mixed $config
     */
    function offsetUnset($config)
    {
        $this->remove($config);
    }

    /**
     * @param string $name
     * @return void
     */
    abstract function remove($name);

    /**
     * @param string $name
     * @param mixed $config
     * @return mixed $config
     */
    abstract function set($name, $config);
}
