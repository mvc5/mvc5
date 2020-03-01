<?php
/**
 *
 */

namespace Mvc5\Config;

interface Model
    extends \ArrayAccess, \Countable, \Iterator
{
    /**
     * @param array|string $name
     * @return mixed
     */
    function get($name);

    /**
     * @param array|string $name
     * @return bool
     */
    function has($name) : bool;

    /**
     * @param array|string $name
     * @param mixed $value
     * @return Model|mixed
     */
    function with($name, $value = null) : Model;

    /**
     * @param array|string $name
     * @return Model|mixed
     */
    function without($name) : Model;
}
