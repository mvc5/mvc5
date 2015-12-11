<?php
/**
 *
 */

namespace Mvc5\Route;

use Throwable;

interface Exception
    extends Error
{
    /**
     * @return Throwable
     */
    function exception();
}
