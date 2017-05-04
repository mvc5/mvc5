<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;

trait Response
{
    /**
     * @return mixed
     */
    function body()
    {
        return $this[Arg::BODY];
    }

    /**
     * @return mixed
     */
    function headers()
    {
        return $this[Arg::HEADERS];
    }

    /**
     * @return string
     */
    function reason()
    {
        return $this[Arg::REASON];
    }

    /**
     * @return int
     */
    function status()
    {
        return $this[Arg::STATUS];
    }

    /**
     * @return int
     */
    function version()
    {
        return $this[Arg::VERSION];
    }
}
