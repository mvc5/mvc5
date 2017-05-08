<?php
/**
 *
 */

namespace Mvc5\Config;

trait ArrayAccess
{
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
}
