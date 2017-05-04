<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

trait Error
{
    /**
     * @return int
     */
    function code()
    {
        return $this[Arg::CODE];
    }

    /**
     * @return string
     */
    function description()
    {
        return $this[Arg::DESCRIPTION];
    }

    /**
     * @return array
     */
    function errors()
    {
        return $this[Arg::ERRORS];
    }

    /**
     * @return string
     */
    function message()
    {
        return $this[Arg::MESSAGE];
    }

    /**
     * @return int
     */
    function status()
    {
        return $this[Arg::STATUS];
    }
}
