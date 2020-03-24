<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

use const Mvc5\PARENT;

trait Child
{
    /**
     *
     */
    use Plugin;

    /**
     * @return string|mixed
     */
    function parent()
    {
        return $this[PARENT];
    }
}
