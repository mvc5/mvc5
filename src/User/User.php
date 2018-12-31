<?php
/**
 *
 */

namespace Mvc5\User;

use Mvc5\Config\Model;

interface User
    extends Model
{
    /**
     * @return bool
     */
    function authenticated() : bool;

    /**
     * @return string|null
     */
    function username() : ?string;
}
