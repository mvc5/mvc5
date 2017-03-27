<?php
/**
 *
 */

namespace Mvc5\Url;

class Collection
{
    /**
     *
     */
    use Route\Generator;

    /**
     * @param $name
     * @return array|mixed
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
