<?php
/**
 *
 */

namespace Mvc5\Plugin;

class GlobalVar
    extends Value
{
    /**
     * @return array|mixed
     */
    function config()
    {
        return $GLOBALS[$this->config] ?? null;
    }
}
