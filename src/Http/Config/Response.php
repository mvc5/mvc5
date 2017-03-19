<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Config\Config;

trait Response
{
    /**
     *
     */
    use Config;

    /**
     * @return mixed
     */
    function body()
    {
        return $this[Arg::BODY];
    }

    /**
     * @return array
     */
    function headers()
    {
        return $this[Arg::HEADERS] ?: [];
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
