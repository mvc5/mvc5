<?php
/**
 *
 */

namespace Mvc5\Config;

use ArrayAccess as ArrayConfig;

interface Configuration
    extends ArrayConfig
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
     * @return void
     */
    function set($name, $config);
}
