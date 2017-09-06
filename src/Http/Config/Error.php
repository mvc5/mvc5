<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

trait Error
{
    /**
     * @return int|null
     */
    function code()
    {
        return $this[Arg::CODE];
    }

    /**
     * @return string|null
     */
    function description()
    {
        return $this[Arg::DESCRIPTION];
    }

    /**
     * @return array
     */
    function errors() : array
    {
        return $this[Arg::ERRORS] ?? [];
    }

    /**
     * @return string|null
     */
    function message()
    {
        return $this[Arg::MESSAGE];
    }

    /**
     * @return int|null
     */
    function status()
    {
        return $this[Arg::STATUS];
    }
}
