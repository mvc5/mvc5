<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Request\Request as _Request;

interface Request
    extends _Request
{
    /**
     * @return int
     */
    function length();

    /**
     * @return bool
     */
    function matched();

    /**
     * @return _Request
     */
    function request();
}
