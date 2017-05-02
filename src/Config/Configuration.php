<?php
/**
 *
 */

namespace Mvc5\Config;

interface Configuration
    extends Model
{
    /**
     * @param array|string $name
     * @return void
     */
    function remove($name);

    /**
     * @param array|string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value = null);
}
