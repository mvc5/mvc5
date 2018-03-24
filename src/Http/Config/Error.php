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
    function code() : ?int
    {
        return $this[Arg::CODE];
    }

    /**
     * @return string|null
     */
    function description() : ?string
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
    function message() : ?string
    {
        return $this[Arg::MESSAGE];
    }

    /**
     * @return int|null
     */
    function status() : ?int
    {
        return $this[Arg::STATUS];
    }
}
