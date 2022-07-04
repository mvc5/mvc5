<?php
/**
 *
 */

namespace Mvc5\Config;

trait Readable
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
     * @throws \Exception
     */
    function offsetSet($name, $value) : void
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    function offsetUnset($name) : void
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    function __set($name, $value)
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    function __unset($name) : void
    {
        throw new \Exception('Invalid operation: object cannot be modified');
    }
}
