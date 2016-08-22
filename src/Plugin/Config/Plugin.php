<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

use Mvc5\Arg;
use Mvc5\Config\Config as _Config;

trait Plugin
{
    /**
     *
     */
    use _Config;

    /**
     * @return array
     */
    function args()
    {
        return $this[Arg::ARGS] ? : [];
    }

    /**
     * @return array
     */
    function calls()
    {
        return $this[Arg::CALLS] ? : [];
    }

    /**
     * @return bool
     */
    function merge()
    {
        return $this[Arg::MERGE] ? : false;
    }

    /**
     * @return string
     */
    function name()
    {
        return $this[Arg::NAME];
    }

    /**
     * @return string
     */
    function param()
    {
        return $this[Arg::PARAM];
    }
}
