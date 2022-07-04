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
    function offsetExists($name) : bool
    {
        return $this->has($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    function offsetGet($name) : mixed
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function offsetSet($name, $value) : void
    {
        $this->set($name, $value);
    }

    /**
     * @param string $name
     */
    function offsetUnset($name) : void
    {
        $this->remove($name);
    }
}
