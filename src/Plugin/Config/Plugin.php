<?php
/**
 *
 */

namespace Mvc5\Plugin\Config;

use Mvc5\Arg;
use Mvc5\Config\ReadOnly;

trait Plugin
{
    /**
     *
     */
    use ReadOnly;

    /**
     * @return array
     */
    function args() : array
    {
        return $this[Arg::ARGS] ? : [];
    }

    /**
     * @return array
     */
    function calls() : array
    {
        return $this[Arg::CALLS] ? : [];
    }

    /**
     * @return bool
     */
    function merge() : bool
    {
        return $this[Arg::MERGE] ? : false;
    }

    /**
     * @return mixed
     */
    function name()
    {
        return $this[Arg::NAME];
    }

    /**
     * @return string|null
     */
    function param()
    {
        return $this[Arg::PARAM];
    }
}
