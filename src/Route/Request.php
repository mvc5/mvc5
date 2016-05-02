<?php
/**
 *
 */

namespace Mvc5\Route;

use Mvc5\Request\Request as Mvc5Request;

interface Request
    extends Mvc5Request
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
     * @return Mvc5Request
     */
    function request();
}
