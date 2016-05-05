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
    abstract function get($name);

    /**
     * @param string $name
     * @return bool
     */
    abstract function has($name);

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
