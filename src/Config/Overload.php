<?php
/**
 *
 */

namespace Mvc5\Config;

trait Overload
{
    /**
     *
     */
    use Config;

    /**
     * @param string $name
     * @return mixed
     */
    function &offsetGet($name)
    {
        return $this->config[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    function &__get($name)
    {
        return $this->offsetGet($name);
    }
}
