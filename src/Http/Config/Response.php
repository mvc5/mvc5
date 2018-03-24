<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Http;

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
     * @return array|Http\Headers
     */
    function headers()
    {
        return $this[Arg::HEADERS];
    }

    /**
     * @return string|null
     */
    function reason() : ?string
    {
        return $this[Arg::REASON];
    }

    /**
     * @return int|null
     */
    function status() : ?int
    {
        return $this[Arg::STATUS];
    }

    /**
     * @return string|null
     */
    function version() : ?string
    {
        return $this[Arg::VERSION];
    }
}
