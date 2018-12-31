<?php
/**
 *
 */

namespace Mvc5\User\Config;

use Mvc5\Arg;

trait User
{
    /**
     * @return bool
     */
    function authenticated() : bool
    {
        return (bool) $this[Arg::AUTHENTICATED];
    }

    /**
     * @return string|null
     */
    function username() : ?string
    {
        return $this[Arg::USERNAME] ?? null;
    }
}
