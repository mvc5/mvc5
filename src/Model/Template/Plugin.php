<?php
/**
 *
 */

namespace Mvc5\Model\Template;

use Mvc5\Plugin as _Plugin;

trait Plugin
{
    /**
     *
     */
    use _Plugin;

    /**
     * @param string $name
     * @param array $args
     * @return mixed
     */
    function __call($name, array $args = [])
    {
        return $this->call($name, $args);
    }
}
