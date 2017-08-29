<?php
/**
 *
 */

namespace Mvc5\Config;

trait ArrayAccess
{
    /**
     * @param string $name
     * @return bool
     */
    function offsetExists($name)
    {
        return $this->has($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function offsetGet($name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function offsetSet($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param string $name
     */
    function offsetUnset($name)
    {
        $this->remove($name);
    }
}
