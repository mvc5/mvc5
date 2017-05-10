<?php
/**
 *
 */

namespace Mvc5\Config;

trait ReadOnly
{
    /**
     *
     */
    use Config {
        remove as protected;
        set as protected;
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return mixed $value
     * @throws \Exception
     */
    function offsetSet($name, $value)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param mixed $name
     * @throws \Exception
     */
    function offsetUnset($name)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return mixed
     * @throws \Exception
     */
    function __set($name, $value)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param mixed $name
     * @throws \Exception
     */
    function __unset($name)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }
}
