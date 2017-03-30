<?php
/**
 *
 */

namespace Mvc5\Config;

use Exception;

trait ReadOnly
{
    /**
     *
     */
    use Config {
        remove as private;
        set as private;
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return mixed $value
     * @throws Exception
     */
    function offsetSet($name, $value)
    {
        throw new Exception('Invalid operation: object cannot be modified');
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return mixed
     * @throws Exception
     */
    function __set($name, $value)
    {
        throw new Exception('Invalid operation: object cannot be modified');
    }
}
