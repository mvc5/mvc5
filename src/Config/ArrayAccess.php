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
     * @param mixed $name
     * @return bool
     */
    function offsetExists($name)
    {
        return $this->has($name);
    }

    /**
     * @param mixed $name
     * @return mixed
     */
    function offsetGet($name)
    {
        return $this->get($name);
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return mixed $value
     */
    function offsetSet($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param mixed $name
     */
    function offsetUnset($name)
    {
        $this->remove($name);
    }

    /**
     * @param string $name
     * @return void
     */
    abstract function remove($name);

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    abstract function set($name, $value);
}
