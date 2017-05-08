<?php
/**
 *
 */

namespace Mvc5\Config;

trait PropertyAccess
{
    /**
     * @param mixed $name
     * @return mixed
     */
    function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param mixed $name
     * @return bool
     */
    function __isset($name)
    {
        return $this->has($name);
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return mixed
     */
    function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param mixed $name
     */
    function __unset($name)
    {
        $this->remove($name);
    }
}
