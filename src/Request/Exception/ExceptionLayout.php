<?php
/**
 *
 */

namespace Mvc5\Request\Exception;

use Mvc5\View\ViewLayout;

interface ExceptionLayout
    extends ViewLayout
{
    /**
     * @return \Throwable
     */
    function exception() : \Throwable;
}
