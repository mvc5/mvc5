<?php
/**
 *
 */

namespace Mvc5\Config;

interface Configuration
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
     * @param string $name
     * @return void
     */
    function remove($name);

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value);

    /**
     * @param string $name
     * @param mixed $value
     * @return self
     */
    function with($name, $value);

    /**
     * @param string $name
     * @return self
     */
    function without($name);
}
