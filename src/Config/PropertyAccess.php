<?php
/**
 *
 */

namespace Mvc5\Config;

trait PropertyAccess
{
    /**
     * @param string $name
     * @return mixed
     */
    function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    function __isset($name) : bool
    {
        return $this->has($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param string $name
     */
    function __unset($name)
    {
        $this->remove($name);
    }
}
