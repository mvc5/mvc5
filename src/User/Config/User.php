<?php
/**
 *
 */

namespace Mvc5\User\Config;

use Mvc5\Arg;
use Mvc5\Config\ReadOnly;

trait User
{
    /**
     *
     */
    use ReadOnly;

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
