<?php
/**
 *
 */

namespace Mvc5\Http\Headers;

use Mvc5\Config as _Config;
use Mvc5\Http\Headers;

class Config
    extends _Config
    implements Headers
{
    /**
     * @param array $config
     */
    function __construct(array $config = [])
    {
        parent::__construct(array_change_key_case($config, CASE_LOWER));
    }

    /**
     * @param string $name
     * @return mixed
     */
    function get($name)
    {
        return parent::get(strtolower($name));
    }

    /**
     * @param string $name
     * @return bool
     */
    function has($name)
    {
        return parent::has(strtolower($name));
    }

    /**
     * @param string $name
     * @return void
     */
    function remove($name)
    {
        parent::remove(strtolower($name));
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    function set($name, $value)
    {
        return parent::set(strtolower($name), $value);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return self|mixed
     */
    function with($name, $value)
    {
        return parent::with(strtolower($name), $value);
    }

    /**
     * @param string $name
     * @return self|mixed
     */
    function without($name)
    {
        return parent::without(strtolower($name));
    }
}
