<?php
/**
 *
 */

namespace Mvc5\User\Config;

use const Mvc5\{ AUTHENTICATED, USERNAME };

trait User
{
    /**
     * @return bool
     */
    function authenticated() : bool
    {
        return (bool) $this[AUTHENTICATED];
    }

    /**
     * @return string|null
     */
    function username() : ?string
    {
        return $this[USERNAME] ?? null;
    }
}
