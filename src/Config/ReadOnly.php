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
     * @param string $name
     * @param mixed $value
     * @return void
     * @throws \Exception
     */
    function offsetSet($name, $value)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param string $name
     * @return void
     * @throws \Exception
     */
    function offsetUnset($name)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     * @throws \Exception
     */
    function __set($name, $value)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param string $name
     * @return void
     * @throws \Exception
     */
    function __unset($name)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }
}
