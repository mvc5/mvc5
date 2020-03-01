<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\View\ViewLayout;
use Throwable;

interface ExceptionLayout
    extends ViewLayout
{
    /**
     * @return Throwable
     */
    function exception() : Throwable;
}
