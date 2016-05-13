<?php
/**
 *
 */

namespace Mvc5\Model\Config;

use Mvc5\Config\Config;

trait Model
{
    /**
     *
     */
    use Config;

    /**
     * @param string $name
     * @return mixed
     */
    function &get($name)
    {
        return $this->config[$name];
    }

    /**
     * @param mixed $name
     * @return mixed
     */
    function &offsetGet($name)
    {
        return $this->get($name);
    }

    /**
     * @param mixed $name
     * @return mixed
     */
    function &__get($name)
    {
        return $this->get($name);
    }
}
