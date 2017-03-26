<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Config\ReadOnly;

trait Request
{
    /**
     *
     */
    use ReadOnly;

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
    function method()
    {
        return $this[Arg::METHOD];
    }

    /**
     * @return mixed
     */
    function uri()
    {
        return $this[Arg::URI];
    }

    /**
     * @return int
     */
    function version()
    {
        return $this[Arg::VERSION];
    }
}
