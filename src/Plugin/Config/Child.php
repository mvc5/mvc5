<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

use Mvc5\Arg;

trait Child
{
    /**
     *
     */
    use Plugin;

    /**
     * @return string
     */
    function parent()
    {
        return $this[Arg::PARENT];
    }
}
