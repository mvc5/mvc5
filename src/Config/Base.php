<?php
/**
 *
 */

namespace Mvc5\Config;

interface Base
    extends \ArrayAccess, \Countable, \Iterator
{
    /**
     * @param string $name
     * @return mixed
     */
    function get($name);

    /**
     * @param string $name
     * @return bool
     */
    function has($name);

    /**
     * @param array|string $name
     * @param mixed $value
     * @return self|mixed
     */
    function with($name, $value = null);

    /**
     * @param array|string $name
     * @return self|mixed
     */
    function without($name);
}
