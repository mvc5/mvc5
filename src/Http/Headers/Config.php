<?php
/**
 *
 */

namespace Mvc5\Http\Headers;

use Mvc5\Immutable;
use Mvc5\Http\Headers;

class Config
    extends Immutable
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
     * @param mixed $value
     * @return self|mixed
     */
    function with($name, $value = null)
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
