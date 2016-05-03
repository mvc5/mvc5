<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Config\Config;

trait Request
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
    function method()
    {
        return $this[Arg::METHOD];
    }

    /**
     * @return string
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
        return $this[Arg::VERSION] ?: Arg::HTTP_VERSION;
    }
}
