<?php
/**
 *
 */

namespace Mvc5\Http\Config;

use Mvc5\Arg;
use Mvc5\Http;

trait Request
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
    function method() : ?string
    {
        return $this[Arg::METHOD];
    }

    /**
     * @return string|Http\Uri|null
     */
    function uri()
    {
        return $this[Arg::URI];
    }

    /**
     * @return string|null
     */
    function version() : ?string
    {
        return $this[Arg::VERSION];
    }
}
