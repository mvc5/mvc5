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
     * @param mixed $config
     * @return mixed
     */
    function set($name, $config);
}
