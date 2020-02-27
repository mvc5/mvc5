<?php
/**
 *
 */

namespace Mvc5\Config;

use function count;

trait Count
{
    /**
     * @return int
     */
    function count() : int
    {
        return count($this->config);
    }
}
