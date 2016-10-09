<?php
/**
 *
 */

namespace Mvc5\Url;

use Mvc5\Route\Route as _Route;

class Collection
{
    /**
     *
     */
    use Route\Generator;

    /**
     * @param $name
     * @return array|_Route
     */
    protected function config($name)
    {
        return isset($this->route[$name]) ? $this->route[$name] : null;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function name($name)
    {
        return $name;
    }
}
